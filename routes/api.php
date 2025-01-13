<?php

use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\Barang;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PeminjamanCotroller;
use Illuminate\Support\Facades\Route;
//

Route::post('/peminjaman-barang', [PeminjamanBarangController::class, 'store']); // Menyimpan data peminjaman
Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index']); // Melihat semua data peminjaman
Route::post('/peminjaman', [PeminjamanCotroller::class, 'store']); // Menyimpan data peminjaman
Route::get('/peminjaman', [PeminjamanCotroller::class, 'index']); // Melihat semua data peminjaman
Route::get('/barang_inventaris', [Barang::class, 'index']);
Route::post('/barang_inventaris', [Barang::class, 'store']);
Route::get('/jenis_barang', [JenisBarangController::class, 'index']);
Route::post('/jenis_barang', [JenisBarangController::class, 'store']);