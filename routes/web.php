<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('barang', \App\Http\Controllers\BarangController::class);
Route::resource('kategoribarang',\App\Http\Controllers\KategoriBarangController::class);
Route::resource('transaksi',  \App\Http\Controllers\TransaksiController::class);

//test template
Route::get('template',function () {
    return view('layouts.dashboard');
});

Route::get('/dashboard2', function () {
    return view('includes.dashboard2');
})->name('dashboard');



