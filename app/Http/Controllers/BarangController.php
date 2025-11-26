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
        $kategoribarang = KategoriBarang::orderBy('nama_kategori')->get();
        return view('barang.create', compact('kategoribarang'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'stok'         => 'required|integer',
            'kategori_id'  => 'required|exists:kategori_barang,id',
            'harga_satuan' => 'required|numeric'
        ]);

        Barang::create($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    
    public function show(Barang $barang)
{
    $barang->load('kategori'); // eager load relasi kategori
    return view('barang.show', compact('barang'));
}


    public function edit(Barang $barang)
    {
       
        $kategoribarang = KategoriBarang::all();
        return view('barang.edit', compact('barang', 'kategoribarang'));
    }

  
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'kategori_id'  => 'required|exists:kategori_barang,id',
        ]);

    
        $barang->update($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

public function destroy(Barang $barang)
{
    $barang->delete();   // hapus instance yang di-inject
    return redirect()->route('barang.index')
                     ->with('success', 'Barang berhasil dihapus');
}

}
