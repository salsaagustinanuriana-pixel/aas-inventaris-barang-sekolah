@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
        Detail Kategori
      </div>
  <div class="card-body mt-4">
    <p><strong>ID : </strong>{{$kategoribarang->id}}</p>
    <p><strong>Nama Kategori : </strong>{{$kategoribarang->nama_kategori}}</p>

    <a href="{{ route('kategoribarang.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i>Kembali
    </a>
     </div>
   </div>
</div>

@endsection

