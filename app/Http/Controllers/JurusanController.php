<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    /**
     * Get all jurusan.
     */
    public function index()
    {
        $user = auth()->user();
        $jurusan = Jurusan::all();
    if ($user->role == 'superuser'){
        return view('superuser/Jurusan/index', [
            'jurusan'=>$jurusan
        ]);
    } elseif($user->role == 'admin') {
        return view('admin/Jurusan/index', [
            'jurusan'=>$jurusan
        ]);
    } else {
        return view('user/Jurusan/index', [
            'jurusan'=>$jurusan
        ]);
    }
    }

    /**
     * Store a new jurusan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan' => 'required|string|max:100',
        ]);

        $jurusan = Jurusan::create($validated);
        $user = auth()->user();

        if ($user->role == 'superuser') {
        return redirect()->route('superuser.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }

    }

    /**
     * Show a specific jurusan.
     */
    public function show($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail jurusan berhasil diambil',
            'data' => $jurusan,
        ], 200);
    }

    /**
     * Update a specific jurusan.
     */
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::find($id);
        $user = auth()->user();
        
    if (!$jurusan) {
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
            'jurusan' => 'required|string|max:100',
        ]);

        $jurusan->update($validated);

        if ($user->role == 'superuser') {
        return redirect()->route('superuser.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil dihapus');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil dihapus');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Delete a specific jurusan.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
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
        $jurusan->delete();
        
        if ($user->role == 'superuser') {
        return redirect()->route('superuser.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil dihapus');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.jurusan', ['jurusan' => $jurusan])
                ->with('success', 'Jurusan berhasil dihapus');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }
}