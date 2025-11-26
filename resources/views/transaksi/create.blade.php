@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Tambah Transaksi</h4>
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" name="kode_transaksi" class="form-control" value="TRX{{ time() }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                </div>

             <div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">METODE PEMBAYARAN</label>
        <select name="jenis" class="form-select" required>
            <option value="cash">Cash</option>
            <option value="credit">Credit</option>
            <option value="transfer">Transfer</option>
        </select>
    </div>
</div>

                <h5 class="fw-bold text-primary mt-4">Detail Barang</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Pilih</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $b)
                        <tr>
                            <td><input type="checkbox" name="barang_id[]" value="{{ $b->id }}"></td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                            <td><input type="number" name="jumlah[]" class="form-control" min="1"></td>
            ,           </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mb-3">
                    <label class="form-label">Nominal Bayar</label>
                    <input type="number" name="bayar" class="form-control" placeholder="Masukkan nominal bayar" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-pencil-squere"></i> Simpan
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

