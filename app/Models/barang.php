<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table    = 'barang';
    protected $fillable = ['nama_barang', 'stok', 'kategori_id', 'harga_satuan'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }
    
}
