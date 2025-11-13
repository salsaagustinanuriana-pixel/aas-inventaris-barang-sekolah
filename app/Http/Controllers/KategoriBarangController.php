<?php
namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategori = KategoriBarang::paginate(10);
        return view('kategori.index', compact('kategori'));
    }

  
    public function create()
    {
        return view('kategori.create');
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barang,nama_kategori',
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    
    public function show(KategoriBarang $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }


    public function update(Request $request, KategoriBarang $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barang,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    
    public function destroy(KategoriBarang $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
