@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Tambah Kategori Barang</h4>

    <form action="{{ route('kategoribarang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}" required>
            @error('nama_kategori')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategoribarang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

