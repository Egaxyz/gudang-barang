<?php

use App\Http\Controllers\Barang_Asal_Controller;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\Barang;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PeminjamanCotroller;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
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

Route::get('/asalBarang', [Barang_Asal_Controller::class, 'index']);
Route::post('/asalBarang', [Barang_Asal_Controller::class, 'store']);

Route::get('/pengguna', [UserController::class, 'index']);
Route::post('/pengguna', [UserController::class, 'store']);

Route::get('/jurusan', [JurusanController::class, 'index']);
Route::post('/jurusan', [JurusanController::class, 'store']);
Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy']);

Route::get('/kelas', [KelasController::class, 'index']);
Route::post('/kelas', [KelasController::class, 'store']);

Route::get('/siswa', [SiswaController::class, 'index']);
Route::post('/siswa', [SiswaController::class, 'store']);