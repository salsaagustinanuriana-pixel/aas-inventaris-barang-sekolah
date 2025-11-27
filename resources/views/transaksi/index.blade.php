@extends('layouts.dashboard')

@section('content')
<div class="container ">
    <h3>Daftar Transaksi</h3>
    <a href="{{ route('transaksi.create') }}" class="btn btn-success mb-3"> Tambah Transaksi</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th> {{-- kolom baru --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $trx)
            <tr>
                <td>{{ $trx->kode_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($trx->jenis) }}</td>
                <td>Rp {{ number_format($trx->total,0,',','.') }}</td>
                <td>Rp {{ number_format($trx->bayar,0,',','.') }}</td>
                <td>Rp {{ number_format($trx->kembalian,0,',','.') }}</td> {{-- tampilkan kembalian --}}
                <td>
                    <a href="{{ route('transaksi.show',$trx->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('transaksi.edit',$trx->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transaksi.destroy',$trx->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection