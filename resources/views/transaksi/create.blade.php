@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h3>Tambah Transaksi</h3>
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kode Transaksi</label>
            <input type="text" name="kode_transaksi" class="form-control" value="{{ 'TRX' . time() }}" readonly>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <select name="jenis" class="form-control" required>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>

        <h4>Detail Barang</h4>
        @foreach($barang as $b)
        <div class="row mb-2">
            <div class="col-md-4">
                <input type="checkbox" name="barang_id[]" value="{{ $b->id }}" data-harga="{{ $b->harga_satuan }}">
                {{ $b->nama }} (Stok: {{ $b->stok }}) - Rp {{ number_format($b->harga_satuan,0,',','.') }}
            </div>
            <div class="col-md-2">
                <input type="number" name="qty[]" class="form-control" placeholder="Jumlah" min="1">
            </div>
        </div>
        @endforeach

        <div class="mb-3">
            <label>Nominal Bayar</label>
            <input type="number" name="bayar" id="bayar" class="form-control" placeholder="Masukkan nominal bayar">
        </div>

        <div class="mb-3">
            <label>Total Bayar</label>
            <input type="text" id="totalBayar" class="form-control" readonly>
        </div>


        <div class="mb-3">
            <label>Kembalian</label>
            <input type="text" id="kembalian" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- Script untuk hitung total dan kembalian --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('input[name="qty[]"]');
        const checkboxInputs = document.querySelectorAll('input[name="barang_id[]"]');
        const totalBayarInput = document.getElementById('totalBayar');
        const bayarInput = document.getElementById('bayar');
        const kembalianInput = document.getElementById('kembalian');

        function hitungTotal() {
            let total = 0;
            checkboxInputs.forEach((checkbox, i) => {
                if (checkbox.checked) {
                    const qty = parseInt(qtyInputs[i].value) || 0;
                    const harga = parseInt(checkbox.getAttribute('data-harga')) || 0;
                    total += qty * harga;
                }
            });
            totalBayarInput.value = total;

            const bayar = parseInt(bayarInput.value) || 0;
            const kembalian = bayar - total;
            kembalianInput.value = kembalian > 0 ? kembalian : 0;
        }

        checkboxInputs.forEach((checkbox, i) => {
            checkbox.addEventListener('change', hitungTotal);
            qtyInputs[i].addEventListener('input', hitungTotal);
        });

        bayarInput.addEventListener('input', hitungTotal);
    });

</script>
@endsection
