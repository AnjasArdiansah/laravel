<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('buku', BukuController::class);

Route::resource('kategori', KategoriController::class)->except(['show']);

Route::prefix('keranjang')->middleware('auth')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/{buku}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});

Route::prefix('transaksi')->middleware('auth')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
});

Route::get('/home', [HomeController::class, 'index']);