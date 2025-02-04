<?php

use App\Http\Controllers\AuthController;
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
use App\Models\pengembalian;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\barang_inventaris;
use Illuminate\Support\Facades\Auth;


//

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'superuser') {
            return redirect()->route('superuser.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'user') {
            return redirect()->route('user.dashboard');
        }

        // Jika role tidak dikenali, logout & arahkan ke login
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role tidak valid.');
    }

    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Route untuk admin
Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [homeController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::get('/admin/barang', [Barang::class, 'index'])->name('admin.barang');
        Route::post('/admin/barang', [Barang::class, 'store']);
        Route::patch('/admin/barang/{id}', [Barang::class, 'update']);
        Route::delete('/admin/barang/{id}', [Barang::class, 'destroy']);

        Route::get('/admin/pengguna', [UserController::class, 'index'])->name('admin.pengguna');
        Route::post('/admin/pengguna', [UserController::class, 'store']);
        Route::patch('/admin/pengguna/{id}', [UserController::class, 'update']);
        Route::delete('/admin/pengguna/{id}', [UserController::class, 'destroy']);

        Route::get('/admin/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('admin.peminjaman-barang'); 
        Route::post('/admin/peminjaman-barang', [PeminjamanBarangController::class, 'store']);
        Route::patch('/admin/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update']);
        Route::delete('/admin/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy']);

        Route::get('/admin/peminjaman', [PeminjamanCotroller::class, 'index'])->name('admin.peminjaman'); 
        Route::post('/admin/peminjaman', [PeminjamanCotroller::class, 'store']);
        Route::patch('/admin/peminjaman/{id}', [PeminjamanCotroller::class, 'update']);
        Route::delete('/admin/peminjaman/{id}', [PeminjamanCotroller::class, 'destroy']);


        Route::get('/admin/laporan-barang', [Barang::class, 'laporan'])->name('admin.laporan-barang');
        Route::get('/admin/laporan-barang/pdf', function () {
            $barang_inventaris = barang_inventaris::all(); 
            $pdf = Pdf::loadView('admin.Laporan_Barang.pdf', compact('barang_inventaris'));
            return $pdf->download('laporan-barang.pdf');
        });

        Route::get('/admin/jenis-barang', [JenisBarangController::class, 'index'])->name('admin.jenis-barang');
        Route::post('/admin/jenis-barang', [JenisBarangController::class, 'store']);
        Route::patch('/admin/jenis-barang/{id}', [JenisBarangController::class, 'update']);
        Route::delete('/admin/jenis-barang/{id}', [JenisBarangController::class, 'destroy']);

        Route::get('/admin/asal-barang', [Barang_Asal_Controller::class, 'index'])->name('admin.asal-barang');
        Route::post('/admin/asal-barang', [Barang_Asal_Controller::class, 'store']);
        Route::patch('/admin/asal-barang/{id}', [Barang_Asal_Controller::class, 'update'])->name('asal-barang.update');
        Route::delete('/admin/asal-barang/{id}', [Barang_Asal_Controller::class, 'destroy']);

        Route::get('/admin/pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian'); 
        Route::post('/admin/pengembalian', [PengembalianController::class, 'store']); 
        Route::get('/admin/pengembalian/pdf', function () {
            $pengembalian = pengembalian::all(); 
            $pdf = Pdf::loadView('admin.Laporan_Pengembalian.pdf', compact('pengembalian'));
            return $pdf->download('pengembalian.pdf');
        });
        Route::patch('/admin/pengembalian/{id}', [PengembalianController::class, 'update']);
        Route::delete('/admin/pengembalian/{id}', [PengembalianController::class, 'destroy']);

        Route::get('/admin/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
        Route::post('/admin/jurusan', [JurusanController::class, 'store']);
        Route::patch('/admin/jurusan/{id}', [JurusanController::class, 'update']);
        Route::delete('/admin/jurusan/{id}', [JurusanController::class, 'destroy']);

        Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas');
        Route::post('/admin/kelas', [KelasController::class, 'store']);
        Route::patch('/admin/kelas/{id}', [KelasController::class, 'update']);
        Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy']);

        Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
        Route::post('/admin/siswa', [SiswaController::class, 'store']);
        Route::patch('/admin/siswa/{id}', [SiswaController::class, 'update']);
        Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy']);
});

    // Route untuk user
Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [homeController::class, 'userDashboard'])->name('user.dashboard');

        Route::get('/user/barang', [Barang::class, 'index'])->name('user.barang');
        Route::post('/user/barang', [Barang::class, 'store']);
        Route::patch('/user/barang/{id}', [Barang::class, 'update']);
        Route::delete('/user/barang/{id}', [Barang::class, 'destroy']);

        Route::get('/user/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('user.peminjaman-barang'); 
        Route::post('/user/peminjaman-barang', [PeminjamanBarangController::class, 'store']);
        Route::patch('/user/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update']);
        Route::delete('/user/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy']);

        Route::get('/user/peminjaman', [PeminjamanCotroller::class, 'index'])->name('user.peminjaman');
        Route::post('/user/peminjaman', [PeminjamanCotroller::class, 'store']);
        Route::patch('/user/peminjaman/{id}', [PeminjamanCotroller::class, 'update']);
        Route::delete('/user/peminjaman/{id}', [PeminjamanCotroller::class, 'destroy']);


        Route::get('/user/barang-belum-kembali', [Barang::class, 'barang_belum_kembali'])->name('barang-belum-kembali');
});

    // Route untuk superuser
Route::middleware(['role:superuser'])->group(function () {
        Route::get('/superuser/dashboard', [homeController  ::class, 'superuserDashboard'])->name('superuser.dashboard');
                
        Route::get('/superuser/barang', [Barang::class, 'index'])->name('superuser.barang');
        Route::post('/superuser/barang', [Barang::class, 'store']);
        Route::patch('/superuser/barang/{id}', [Barang::class, 'update']);
        Route::delete('/superuser/barang/{id}', [Barang::class, 'destroy']);

        Route::get('/superuser/pengguna', [UserController::class, 'index'])->name('superuser.pengguna');
        Route::post('/superuser/pengguna', [UserController::class, 'store']);
        Route::patch('/superuser/pengguna/{id}', [UserController::class, 'update']);
        Route::delete('/superuser/pengguna/{id}', [UserController::class, 'destroy']);

        Route::get('/superuser/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('superuser.peminjaman-barang'); // Melihat semua data peminjaman
        Route::post('/superuser/peminjaman-barang', [PeminjamanBarangController::class, 'store']); // Menyimpan data peminjaman
        Route::patch('/superuser/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update']);
        Route::delete('/superuser/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy']);

        Route::get('/superuser/peminjaman', [PeminjamanCotroller::class, 'index'])->name('superuser.peminjaman'); // Melihat semua data peminjaman
        Route::post('/superuser/peminjaman', [PeminjamanCotroller::class, 'store']); // Menyimpan data peminjaman
        Route::patch('/superuser/peminjaman/{id}', [PeminjamanCotroller::class, 'update']);
        Route::delete('/superuser/peminjaman/{id}', [PeminjamanCotroller::class, 'destroy']);


        Route::get('/superuser/laporan-barang', [Barang::class, 'laporan'])->name('laporan-barang');
        Route::get('/superuser/laporan-barang/pdf', function () {
            $barang_inventaris = barang_inventaris::all(); // Change to the correct variable
            $pdf = Pdf::loadView('SuperUser.Laporan_Barang.pdf', compact('barang_inventaris')); // Pass the correct variable
            return $pdf->download('laporan-barang.pdf');
        });
        Route::get('/superuser/barang-belum-kembali', [Barang::class, 'barang_belum_kembali'])->name('barang-belum-kembali');

        Route::get('/superuser/jenis-barang', [JenisBarangController::class, 'index'])->name('superuser.jenis-barang');
        Route::post('/superuser/jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
        Route::patch('/superuser/jenis-barang/{id}', [JenisBarangController::class, 'update']);
        Route::delete('/superuser/jenis-barang/{id}', [JenisBarangController::class, 'destroy']);

        Route::get('/superuser/asal-barang', [Barang_Asal_Controller::class, 'index'])->name('superuser.asal-barang');
        Route::post('/superuser/asal-barang', [Barang_Asal_Controller::class, 'store']);
        Route::patch('/superuser/asal-barang/{id}', [Barang_Asal_Controller::class, 'update'])->name('asal-barang.update');
        Route::delete('/superuser/asal-barang/{id}', [Barang_Asal_Controller::class, 'destroy']);

        Route::get('/superuser/pengembalian', [PengembalianController::class, 'index'])->name('superuser.pengembalian'); 
        Route::post('/superuser/pengembalian', [PengembalianController::class, 'store']); 
        Route::get('/superuser/pengembalian/pdf', function () {
            $pengembalian = pengembalian::all(); 
            $pdf = Pdf::loadView('SuperUser.Laporan_Pengembalian.pdf', compact('pengembalian'));
            return $pdf->download('pengembalian.pdf');
        });
        Route::patch('/superuser/pengembalian/{id}', [PengembalianController::class, 'update']);
        Route::delete('/superuser/pengembalian/{id}', [PengembalianController::class, 'destroy']);

        Route::get('/superuser/jurusan', [JurusanController::class, 'index'])->name('superuser.jurusan');
        Route::post('/superuser/jurusan', [JurusanController::class, 'store']);
        Route::patch('/superuser/jurusan/{id}', [JurusanController::class, 'update']);
        Route::delete('/superuser/jurusan/{id}', [JurusanController::class, 'destroy']);

        Route::get('/superuser/kelas', [KelasController::class, 'index'])->name('superuser.kelas');
        Route::post('/superuser/kelas', [KelasController::class, 'store']);
        Route::patch('/superuser/kelas/{id}', [KelasController::class, 'update']);
        Route::delete('/superuser/kelas/{id}', [KelasController::class, 'destroy']);

        Route::get('/superuser/siswa', [SiswaController::class, 'index'])->name('superuser.siswa');
        Route::post('/superuser/siswa', [SiswaController::class, 'store']);
        Route::patch('/superuser/siswa/{id}', [SiswaController::class, 'update']);
        Route::delete('/superuser/siswa/{id}', [SiswaController::class, 'destroy']);
}); 