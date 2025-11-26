<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Halaman daftar transaksi
    public function index()
    {
        $transaksi = Transaksi::all();
        return view('transaksi.index', compact('transaksi'));
    }

    // Form tambah transaksi
    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact( 'barang'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jenis'   => 'required|string', // fleksibel: cash, credit, dll
        'bayar'   => 'required|numeric|min:0',
    ]);

    $total = 0;

    // buat transaksi dulu
    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX' . time(),
        'tanggal'        => $request->tanggal,
        'jenis'          => $request->jenis,
        'bayar'          => $request->bayar,
        'total'          => 0,
        'kembalian'      => 0,
    ]);

    // hitung total dari barang
    if ($request->barang_id) {
        foreach ($request->barang_id as $index => $barangId) {
            $barang   = Barang::find($barangId);
            $jumlah   = $request->jumlah[$index] ?? 1;
            $subtotal = $barang->harga_satuan * $jumlah;
            $total += $subtotal;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id'    => $barangId,
                'jumlah'       => $jumlah,
                'subtotal'     => $subtotal,
            ]);
        }
    }

    // hitung kembalian
    $kembalian = $request->bayar - $total;

    $transaksi->update([
        'total'     => $total,
        'kembalian' => $kembalian > 0 ? $kembalian : 0,
    ]);

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
}

// Update transaksi
public function update(Request $request, $id)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jenis'   => 'required|string',
        'bayar'   => 'required|numeric|min:0',
    ]);

    $transaksi = Transaksi::findOrFail($id);

    $total = 0;

    // update transaksi utama dulu
    $transaksi->update([
        'tanggal' => $request->tanggal,
        'jenis'   => $request->jenis,
        'bayar'   => $request->bayar,
    ]);

    // hapus detail lama
    $transaksi->details()->delete();

    // simpan detail baru
    if ($request->items) {
        foreach ($request->items as $item) {
            $barang   = Barang::find($item['barang_id']);
            $jumlah   = $item['jumlah'] ?? 1;
            $subtotal = $barang->harga_satuan * $jumlah;
            $total   += $subtotal;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id'    => $item['barang_id'],
                'jumlah'       => $jumlah,
                'subtotal'     => $subtotal,
            ]);
        }
    }

    // hitung kembalian
    $kembalian = $request->bayar - $total;

    $transaksi->update([
        'total'     => $total,
        'kembalian' => $kembalian > 0 ? $kembalian : 0,
    ]);

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
}


    // Form edit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        $barang    = Barang::all();
        return view('transaksi.edit', compact('transaksi', 'barang'));
    }

    // Update transaksi
   

    // Detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with([ 'details.barang'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    // Hapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
