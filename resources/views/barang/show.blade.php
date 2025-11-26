@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h4>Detail Barang</h4>
    <table class="table table-bordered">
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $barang->kategori->nama_kategori }}</td>
        </tr>
        <tr>
            <th>Stok</th>
            <td>{{ $barang->stok }}</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>{{ number_format($barang->harga_satuan,0,',','.') }}</td>
        </tr>
    </table>
    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

