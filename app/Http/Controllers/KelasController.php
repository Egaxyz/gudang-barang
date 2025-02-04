<?php

namespace App\Http\Controllers;

use App\Models\jurusan;
use Illuminate\Http\Request;
use App\Models\kelas;

class KelasController extends Controller
{
    /**
     * Get all kelas.
     */
    public function index()
    {
        $jurusan = jurusan::all();
        $user = auth()->user();
        $kelas = kelas::with('jurusan')->get();

        if ($user->role == 'superuser'){
        return view('superuser/Kelas/index', [
            'kelas' => $kelas,
            'jurusan'=>$jurusan
        ]);
    } elseif($user->role == 'admin') {
        return view('admin/Kelas/index', [
            'kelas' => $kelas,
            'jurusan'=>$jurusan
        ]);
    } else {
        return abort(403, 'Unauthorized action.');
    }
    }

    /**
     * Store a new kelas.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
    'tingkatan' => 'required',
    'konsentrasi' => 'required',
    'no_konsentrasi' => 'required',
    'jurusan_id' => 'required',
]);
        $jurusan = jurusan::all();
        $user = auth()->user();
        $kelas = Kelas::create($validated);

        if ($user->role == 'superuser') {
        return redirect()->route('superuser.kelas', ['jurusan' => $jurusan, 'kelas'=> $kelas])
                ->with('success', 'Kelas berhasil ditambahkan');
        } elseif ($user->role == 'admin') {
        return redirect()->route('admin.kelas', ['jurusan' => $jurusan, 'kelas'=> $kelas])
                ->with('success', 'Kelas berhasil ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show a specific kelas.
     */
    public function show($id)
    {
        $kelas = kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'kelas Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kelas berhasil diambil',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Update a specific kelas.
     */
    public function update(Request $request, $kelas_id)
    {
        $kelas = Kelas::find($kelas_id);
        $user = auth()->user();

          if (!$kelas) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Jurusan Tidak Ditemukan untuk superuser',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin Tidak Dapat mengakses jurusan ini',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }

        $validated = $request->validate([
            'tingkatan' => 'required',
            'konsentrasi' => 'required',
            'no_konsentrasi' => 'required',
                ]);

        $kelas->update($validated);

        if ($user->role == 'superuser') {
        return redirect()->route('superuser.kelas', ['kelas' => $kelas])
                ->with('success', 'Kelas berhasil dihapus');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.kelas', ['kelas' => $kelas])
                ->with('success', 'Kelas berhasil dihapus');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Delete a specific kelas.
     */
    public function destroy($kelas_id)
    {
        $kelas = kelas::find($kelas_id);

        $user = auth()->user();

          if (!$kelas) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas Tidak Ditemukan',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas Tidak Ditemukan',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }

        $kelas->delete();

        if ($user->role == 'superuser') {
        return redirect()->route('superuser.kelas', ['kelas' => $kelas])
                ->with('success', 'Kelas berhasil dihapus');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.kelas', ['kelas' => $kelas])
                ->with('success', 'Kelas berhasil dihapus');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }
}