<?php

use App\Http\Controllers\Barang_Asal_Controller;
use App\Http\Controllers\homeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\Barang;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PeminjamanCotroller;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
//

Route::get('/home', [homeController::class, 'index']);

Route::post('/peminjaman-barang', [PeminjamanBarangController::class, 'store']); // Menyimpan data peminjaman
Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index']); // Melihat semua data peminjaman
Route::put('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update']);
Route::delete('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy']);

Route::post('/peminjaman', [PeminjamanCotroller::class, 'store']); // Menyimpan data peminjaman
Route::get('/peminjaman', [PeminjamanCotroller::class, 'index']); // Melihat semua data peminjaman
Route::put('/peminjaman/{id}', [PeminjamanCotroller::class, 'update']);
Route::delete('/peminjaman/{id}', [PeminjamanCotroller::class, 'destroy']);

Route::get('/barang', [Barang::class, 'index']);
Route::post('/barang', [Barang::class, 'store']);
Route::put('/barang/{id}', [Barang::class, 'update']);
Route::delete('/barang/{id}', [Barang::class, 'destroy']);

Route::get('/laporan-barang', [Barang::class, 'laporan'])->name('laporan-barang');

Route::get('/barang-belum-kembali', [Barang::class, 'barang_belum_kembali'])->name('barang-belum-kembali');

Route::get('/jenis-barang', [JenisBarangController::class, 'index']);
Route::post('/jenis-barang', [JenisBarangController::class, 'store']);
Route::put('/jenis-barang/{id}', [JenisBarangController::class, 'update']);
Route::delete('/jenis-barang/{id}', [JenisBarangController::class, 'destroy']);

Route::get('/asal-barang', [Barang_Asal_Controller::class, 'index']);
Route::post('/asal-barang', [Barang_Asal_Controller::class, 'store']);
Route::put('/asal-barang/{id}', [Barang_Asal_Controller::class, 'update']);
Route::delete('/asal-barang/{id}', [Barang_Asal_Controller::class, 'destroy']);

Route::get('/pengguna', [UserController::class, 'index']);
Route::post('/pengguna', [UserController::class, 'store']);
Route::put('/pengguna/{id}', [UserController::class, 'update']);
Route::delete('/pengguna/{id}', [UserController::class, 'destroy']);

Route::get('/jurusan', [JurusanController::class, 'index']);
Route::post('/jurusan', [JurusanController::class, 'store']);
Route::put('/jurusan/{id}', [JurusanController::class, 'update']);
Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy']);

Route::get('/kelas', [KelasController::class, 'index']);
Route::post('/kelas', [KelasController::class, 'store']);
Route::put('/kelas/{id}', [KelasController::class, 'update']);
Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

Route::get('/siswa', [SiswaController::class, 'index']);
Route::post('/siswa', [SiswaController::class, 'store']);
Route::put('/siswa/{id}', [SiswaController::class, 'update']);
Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);

Route::post('/pengembalian', [PengembalianController::class, 'store']); // Menyimpan data peminjaman
Route::get('/pengembalian', [PengembalianController::class, 'index']); // Melihat semua data peminjaman
Route::put('/pengembalian/{id}', [PengembalianController::class, 'update']);
Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy']);