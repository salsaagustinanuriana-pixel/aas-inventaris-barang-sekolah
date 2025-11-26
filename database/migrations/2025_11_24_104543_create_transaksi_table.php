<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
   
   
public function up()
{
    Schema::create('transaksi', function (Blueprint $table) {
    $table->id(); // auto_increment hanya di sini
    $table->string('kode_transaksi')->unique();
    $table->date('tanggal');
    $table->string('jenis');                         // cash, credit, transfer, dll
    $table->decimal('total', 20, 2)->default(0);     // total transaksi
    $table->decimal('bayar', 20, 2)->default(0);     // nominal bayar
    $table->decimal('kembalian', 20, 2)->default(0); // hasil bayar - total
    $table->text('keterangan')->nullable();
    $table->timestamps();
});

}


    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
