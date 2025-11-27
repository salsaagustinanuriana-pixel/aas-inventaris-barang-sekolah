@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Edit Transaksi</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('transaksi.update',$transaksi->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Kode Transaksi</label>
                <input type="text" name="kode_transaksi" class="form-control" value="{{ old('kode_transaksi',$transaksi->kode_transaksi) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal',$transaksi->tanggal) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Jenis</label>
                <select name="jenis" class="form-control" required>
                    <option value="masuk" @selected(old('jenis',$transaksi->jenis)=='masuk')>Masuk</option>
                    <option value="keluar" @selected(old('jenis',$transaksi->jenis)=='keluar')>Keluar</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan',$transaksi->keterangan) }}</textarea>
        </div>

        <hr>
        <h5>Detail Barang</h5>
        <div id="items">
            @foreach($transaksi->details as $i => $detail)
            <div class="row g-2 mb-2 item-row">
                <div class="col-md-6">
                    <select name="items[{{ $i }}][barang_id]" class="form-control" required>
                        @foreach($barang as $b)
                        <option value="{{ $b->id }}" @selected($detail->barang_id==$b->id)>
                            {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" value="{{ old('items.'.$i.'.jumlah',$detail->jumlah) }}" min="1" required>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.item-row').remove()">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-2">Update Transaksi</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-2">Batal</a>
    </form>
</div>

<script>
    let idx = {
        {
            $transaksi - > details - > count()
        }
    };

    function addItemRow() {
        const container = document.getElementById('items');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 item-row';
        row.innerHTML = `
        <div class="col-md-6">
            <select name="items[${idx}][barang_id]" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                <option value="{{ $b->id }}">{{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${idx}][jumlah]" class="form-control" placeholder="Jumlah" min="1" required>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="button" class="btn btn-danger" onclick="this.closest('.item-row').remove()">Hapus</button>
        </div>
    `;
        container.appendChild(row);
        idx++;
    }

</script>
@endsection