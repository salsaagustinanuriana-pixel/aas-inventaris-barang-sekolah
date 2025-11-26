@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Tambah Barang</h2>
    <div class="alert alert-danger">
        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>

             <div class="mb-3">
                 <label for="stok" class="form-label">Stok</label>
                 <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" min="0" required>
             </div>



            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoribarang as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

           

            <div class="mb-3">
                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                <input type="number" name="harga_satuan" class="form-control" value="{{ old('harga_satuan') }}" min="0" required>
            </div>

             <button href="{{ route('barang.index') }}" class="btn btn-success btn-sm">
                 <i class="bi bi-pencil-square"></i> Simpan
             </button>
             <a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm">
                 <i class="bi bi-pencil-square"></i> Kembali
             </a>

           
        </form>
    </div>
    @endsection

