<?php
namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategoribarang = KategoriBarang::all();
        return view('kategoribarang.index', compact('kategoribarang'));
    }

    public function create()
    {
        return view('kategoribarang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barang,nama_kategori',
        ]);

        KategoriBarang::create($request->all());
        return redirect()->route('kategoribarang.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(KategoriBarang $kategoribarang)
    {
        return view('kategoribarang.show', compact('kategoribarang'));
    }

    public function edit(KategoriBarang $kategoribarang)
    {
        return view('kategoribarang.edit', compact('kategoribarang'));
    }

    public function update(Request $request, KategoriBarang $kategoribarang)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategoribarang->update($request->all());
        return redirect()->route('kategoribarang.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(KategoriBarang $kategoribarang)
    {
        // cek apakah kategori masih dipakai di tabel barang
        if ($kategoribarang->barang()->exists()) {
            return redirect()->route('kategoribarang.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan pada barang.');
        }

        $kategoribarang->delete();
        return redirect()->route('kategoribarang.index')->with('success', 'Kategori berhasil dihapus');
    }
}
    