@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="border border-primary p-5 text-center" style="background-color: #fff; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <h1 class="fw-bold text-primary mb-7" style="font-size: 2rem;">📚 SELAMAT DATANG DI INVENTARIS BARANG SEKOLAH 🎉</h1>
        <p class="text-muted" style="font-size: 1.2rem;">
            “Inventaris barang sekolah, rapi, lcu, dan siap menemani belajar 😎✨”
        </p>
    </div>
</div>

{{-- Custom Style --}}
<style>
    body {
        background-color: #f8f9fa;
    }
</style>
@endsection
