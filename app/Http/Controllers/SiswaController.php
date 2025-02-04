<?php

namespace App\Http\Controllers;

use App\Models\jurusan;
use App\Models\kelas;
use Illuminate\Http\Request;
use App\Models\siswa;

class SiswaController extends Controller
{
    /**
     * Get all siswa.
     */
    public function index()
    {
        $siswa = siswa::with('jurusanData', 'kelasData')->get();

        $kelas = kelas::all();
        $jurusan = jurusan::all();
        $user = auth()->user();
        if ($user->role == 'superuser'){
        return view('superuser/Daftar_Siswa/index', [
            'siswa' => $siswa,
            'kelasData'=>$kelas,
            'jurusanData'=>$jurusan
        ]);
    } else {
        return view('admin/Daftar_Siswa/index', [
            'siswa' => $siswa,
            'kelasData'=>$kelas,
            'jurusanData'=>$jurusan
        ]);
    }
    }

    /**
     * Store a new siswa.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'nama_siswa' => 'required',
        'nis' => 'required|unique:siswa,nis', // Validasi unik di Laravel
        'no_hp' => 'required',
        'kelas_id' => 'required',
        'jurusan_id' => 'required',
    ]);


    $siswa = siswa::create($validated);
        

        $user = auth()->user();
           if ($user->role == 'superuser') {
        return redirect()->route('superuser.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show a specific siswa.
     */
    public function show($id)
    {
        $siswa = siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'siswa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail siswa berhasil diambil',
            'data' => $siswa,
        ], 200);
    }

    /**
     * Update a specific siswa.
     */
    public function update(Request $request, $id)
    {
        $siswa = siswa::find($id);

        $user = auth()->user();
                if (!$siswa) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa Tidak Ditemukan',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa Tidak Ditemukan',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }

        $validated = $request->validate([
             'nama_siswa' =>  'required',
            'nis'=>'required',
            'no_hp'=>'required',
        ]);

        $siswa->update($validated);
        $user = auth()->user();
           if ($user->role == 'superuser') {
        return redirect()->route('superuser.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Delete a specific siswa.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $siswa = siswa::find($id);

        if (!$siswa) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa Tidak Ditemukan',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa Tidak Ditemukan',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }
        $siswa->delete();

        $user = auth()->user();
           if ($user->role == 'superuser') {
        return redirect()->route('superuser.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.siswa')
                ->with('success', 'Siswa Berhasil Ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }
}