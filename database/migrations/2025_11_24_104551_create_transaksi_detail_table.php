<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('transaksi_detail', function (Blueprint $table) {
    $table->id();
    $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
    $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
    $table->integer('qty'); // jumlah barang
    $table->decimal('subtotal', 20, 2)->default(0); // harga_satuan * qty
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};