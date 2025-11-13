<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
   public function index()
   {
       $barang = Barang::all();
       return view('barang.index', compact('barang'));
   }


   public function create()
    {
        $kategori = KategoriBarang::all();
        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
            'kategori_id'  => 'required|exists:kategori_barang,id',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }


      public function edit(Barang $barang)
    {
        $kategori = KategoriBarang::all();
        return view('barang.edit', compact('barang','kategori'));
    }


      public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
            'kategori_id'  => 'required|exists:kategori_barang,id',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

      public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}