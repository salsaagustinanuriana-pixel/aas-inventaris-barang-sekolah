@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Barang</h4>
        <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $b)
            <tr>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ optional($b->kategori)->nama_kategori }}</td>
                <td>Rp{{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-center">
                    <a href="{{ route('barang.show', $b->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-eye"></i> Show
                    </a>
                    <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('barang.destroy', $b->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

