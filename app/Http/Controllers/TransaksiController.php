<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('details.barang')->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
{
    DB::transaction(function () use ($request) {
        $kode = 'TRX' . time();

        // buat transaksi awal
        $transaksi = Transaksi::create([
            'kode_transaksi' => $kode,
            'jenis'          => $request->jenis,
            'tanggal'        => $request->tanggal,
            'bayar'          => $request->bayar ?? 0,
            'total'          => 0,
            'kembalian'      => 0, // tambahkan kolom kembalian
        ]);

        $total = 0;

        foreach ($request->barang_id as $i => $barangId) {
            $qty    = $request->qty[$i];
            $barang = Barang::findOrFail($barangId);

            if ($request->jenis == 'keluar' && $barang->stok < $qty) {
                throw new \Exception("Stok barang '{$barang->nama}' tidak mencukupi");
            }

            $subtotal = $barang->harga_satuan * $qty;
            $total += $subtotal;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id'    => $barangId,
                'qty'          => $qty,
                'subtotal'     => $subtotal,
            ]);

            // update stok
            $barang->stok += ($request->jenis == 'masuk') ? $qty : -$qty;
            $barang->save();
        }

        // hitung kembalian
        $bayar = $request->bayar ?? 0;
        $kembalian = $bayar - $total;

        // update transaksi dengan total & kembalian
        $transaksi->update([
            'total'     => $total,
            'kembalian' => $kembalian,
        ]);
    });

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
}


    public function edit($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        $barang    = Barang::all();
        return view('transaksi.edit', compact('transaksi', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'jenis'   => $request->jenis,
            'bayar'   => $request->bayar,
            'total'   => 0,
        ]);

        // rollback stok lama
        foreach ($transaksi->details as $detail) {
            $barang = Barang::findOrFail($detail->barang_id);
            $barang->stok += ($transaksi->jenis == 'masuk') ? -$detail->qty : $detail->qty;
            $barang->save();
        }

        $transaksi->details()->delete();

        $total = 0;
        foreach ($request->barang_id as $i => $barangId) {
            $qty      = $request->qty[$i];
            $barang   = Barang::findOrFail($barangId);
            $subtotal = $barang->harga_satuan * $qty;
            $total += $subtotal;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id'    => $barangId,
                'qty'          => $qty,
                'subtotal'     => $subtotal,
            ]);

            // update stok baru
            $barang->stok += ($request->jenis == 'masuk') ? $qty : -$qty;
            $barang->save();
        }

        $transaksi->update(['total' => $total]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('details.barang')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);

        // rollback stok
        foreach ($transaksi->details as $detail) {
            $barang = Barang::findOrFail($detail->barang_id);
            $barang->stok += ($transaksi->jenis == 'masuk') ? -$detail->qty : $detail->qty;
            $barang->save();
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}