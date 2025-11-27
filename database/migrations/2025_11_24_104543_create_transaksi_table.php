<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
      Schema::create('transaksi', function (Blueprint $table) {
    $table->id();
    $table->string('kode_transaksi')->unique();
    $table->date('tanggal');
    $table->enum('jenis', ['masuk', 'keluar']);
    $table->integer('total')->default(0);
    $table->integer('bayar')->default(0);
    $table->integer('kembalian')->default(0); 
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
