<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;

// Authentication Routes
Auth::routes();

// Main Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Buku Routes
Route::resource('buku', BukuController::class);

// Kategori Routes
Route::resource('kategori', KategoriController::class)->except(['show']);

// Keranjang Routes (Hanya untuk user terautentikasi)
Route::prefix('keranjang')->middleware('auth')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/{buku}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});

// Transaksi Routes (Hanya untuk user terautentikasi)
Route::prefix('transaksi')->middleware('auth')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
});

// Admin Routes (Hanya untuk admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/transaksi', [AdminTransaksiController::class, 'adminIndex'])->name('transaksi.index');
    Route::put('/transaksi/{transaksi}/status', [AdminTransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
});

// Home Route Alternatif (tanpa duplikasi nama)
Route::get('/home', [HomeController::class, 'index']);