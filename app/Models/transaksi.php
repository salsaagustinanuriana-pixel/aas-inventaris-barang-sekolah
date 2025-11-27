<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table    = 'transaksi'; // pakai singular
    protected $fillable = ['kode_transaksi', 'tanggal', 'jenis', 'total', 'bayar', 'kembalian'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}