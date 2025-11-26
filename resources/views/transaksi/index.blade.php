@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Daftar Transaksi</h4>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>KODE</th>
                        <th>TANGGAL</th>
                        <th>MTODE PEMBAYARAN</th>
                        <th>TOTAL</th>
                        <th>BAYAR</th>
                        <th>KEMBALIAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td>{{ $t->kode_transaksi }}</td>
                        <td>{{ $t->tanggal }}</td>
                        <td>{{ ucfirst($t->jenis) }}</td>
                        <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                        <td>
                            @php $kembalian = $t->bayar - $t->total; @endphp
                            <span class="{{ $kembalian < 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($kembalian, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-info btn-sm">Simpan
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('transaksi.edit', $t->id) }}" class="btn btn-warning btn-sm" >
                                    <i class="bi bi-pencil-square"></i>edit
                                </a>
                                <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" >
                                        <i class="bi bi-trash"></i>delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
