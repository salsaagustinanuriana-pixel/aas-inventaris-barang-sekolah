<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar transaksi.
     */
    public function index()
    {
        $transaksi = Transaksi::with('details.barang')->latest()->paginate(10);
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Form tambah transaksi.
     */
    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact('barang'));
    }

    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'           => 'required|date',
            'jenis'             => 'required|in:masuk,keluar',
            'keterangan'        => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $transaksi = Transaksi::create([
                'kode_transaksi' => strtoupper('TRX-' . Str::random(8)),
                'tanggal'        => $validated['tanggal'],
                'jenis'          => $validated['jenis'],
                'keterangan'     => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $barang = Barang::lockForUpdate()->find($item['barang_id']);
                $jumlah = (int) $item['jumlah'];

                if ($validated['jenis'] === 'masuk') {
                    $barang->stok += $jumlah;
                } else {
                    if ($barang->stok < $jumlah) {
                        throw new \RuntimeException("Stok barang '{$barang->nama_barang}' tidak mencukupi.");
                    }
                    $barang->stok -= $jumlah;
                }
                $barang->save();

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $barang->id,
                    'jumlah'       => $jumlah,
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
    }

    /**
     * Detail transaksi.
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('details.barang');
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Form edit transaksi.
     */
    public function edit(Transaksi $transaksi)
    {
        $barang = Barang::all();
        $transaksi->load('details.barang');
        return view('transaksi.edit', compact('transaksi', 'barang'));
    }

    /**
     * Update transaksi.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'tanggal'           => 'required|date',
            'jenis'             => 'required|in:masuk,keluar',
            'keterangan'        => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $transaksi) {
            // rollback stok lama
            foreach ($transaksi->details as $detail) {
                $barang = Barang::lockForUpdate()->find($detail->barang_id);
                if ($transaksi->jenis === 'masuk') {
                    $barang->stok -= $detail->jumlah;
                } else {
                    $barang->stok += $detail->jumlah;
                }
                $barang->save();
            }
            $transaksi->details()->delete();

            // update transaksi
            $transaksi->update([
                'tanggal'    => $validated['tanggal'],
                'jenis'      => $validated['jenis'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // apply stok baru
            foreach ($validated['items'] as $item) {
                $barang = Barang::lockForUpdate()->find($item['barang_id']);
                $jumlah = (int) $item['jumlah'];

                if ($validated['jenis'] === 'masuk') {
                    $barang->stok += $jumlah;
                } else {
                    if ($barang->stok < $jumlah) {
                        throw new \RuntimeException("Stok barang '{$barang->nama_barang}' tidak mencukupi.");
                    }
                    $barang->stok -= $jumlah;
                }
                $barang->save();

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $barang->id,
                    'jumlah'       => $jumlah,
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Hapus transaksi.
     */
    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            foreach ($transaksi->details as $detail) {
                $barang = Barang::lockForUpdate()->find($detail->barang_id);
                if ($transaksi->jenis === 'masuk') {
                    $barang->stok -= $detail->jumlah;
                } else {
                    $barang->stok += $detail->jumlah;
                }
                $barang->save();
            }
            $transaksi->details()->delete();
            $transaksi->delete();
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
