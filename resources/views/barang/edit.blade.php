@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Edit Barang</h4>
    <form action="{{ route('barang.update',$barang->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang',$barang->nama_barang) }}">
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control">
                @foreach($kategoribarang as $k)
                <option value="{{ $k->id }}" @selected($barang->kategori_id==$k->id)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok',$barang->stok) }}">
        </div>
        <div class="mb-3">
            <label>Harga Satuan</label>
            <input type="number" name="harga_satuan" class="form-control" value="{{ old('harga_satuan',$barang->harga_satuan) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

