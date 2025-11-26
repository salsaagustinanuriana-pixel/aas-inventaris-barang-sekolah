@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Edit Kategori</h4>
    <form action="{{ route('kategoribarang.update',$kategoribarang->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori',$kategoribarang->nama_kategori) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('kategoribarang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

