<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TransaksiAdminController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('buku', BukuController::class);

Route::resource('kategori', KategoriController::class)->except(['show']);

Route::prefix('keranjang')->middleware('auth')->group(function () {
    Route::post('/{buku}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::get('/', [KeranjangController::class, 'index'])->name('keranjang.index');
});

Route::prefix('transaksi')->middleware('auth')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
});

// Admin routes without middleware
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/transaksi', [TransaksiAdminController::class, 'index'])->name('transaksi.index');
    Route::put('/transaksi/{transaksi}/status', [TransaksiAdminController::class, 'updateStatus'])->name('transaksi.updateStatus');
});

Route::get('/home', [HomeController::class, 'index']);