@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Kategori Barang</h4>
        <a href="{{ route('kategoribarang.create') }}" class="btn btn-outline-primary">Tambah Kategori</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-primary text-center">
            <tr>
                <th style="width: 60%">Nama Kategori</th>
                <th style="width: 40%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoribarang as $k)
            <tr>
                <td class="align-middle">{{ $k->nama_kategori }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('kategoribarang.show', $k->id) }}" class="btn btn-outline-info btn-sm">Show</a>
                        <a href="{{ route('kategoribarang.edit', $k->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                        <form action="{{ route('kategoribarang.destroy', $k->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">Belum ada kategori barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
