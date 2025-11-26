@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Detail Transaksi</h4>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
            <p><strong>Jenis:</strong> {{ ucfirst($transaksi->jenis) }}</p>
            <p><strong>User:</strong> {{ $transaksi->user?->name ?? 'User tidak tersedia' }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total,0,',','.') }}</p>
            <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar,0,',','.') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Detail Barang</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi->details as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->barang->harga_satuan,0,',','.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada detail barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('transaksi.edit',$transaksi->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection

