<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{


    // Nama tabel
    protected $table = 'barang';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'nama_barang',
        'stok',
        'kategori_id',
        'harga_satuan',
    ];

    /**
     * Relasi ke KategoriBarang (Many to One).
     * Satu barang hanya punya satu kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    /**
     * Relasi ke TransaksiDetail (One to Many).
     * Satu barang bisa muncul di banyak detail transaksi.
     */
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'barang_id');
    }
}
