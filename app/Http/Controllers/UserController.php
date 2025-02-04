<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenggunaRequest;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all users.
     */
    public function index()
    {
        $pengguna = Pengguna::all();
        $user = auth()->user();
        if ($user->role == 'superuser'){
        return view('superuser/Pengguna/index', [
            'pengguna' => $pengguna,
        ]);
    } else {
        return view('admin/Pengguna/index', [
            'pengguna' => $pengguna,
        ]);
    }
    }

    public function store(StorePenggunaRequest $request)
    {
        $validated = $request->validate([
            'user_nama' => 'required|max:50',
            'user_pass' => 'required|min:8',
            'role' => 'required|in:superuser,admin,user',
            'user_sts'=> 'required'
        ]);

        $validated['user_pass'] = bcrypt($validated['user_pass']); // Hash password
        $validated['user_sts'] = $request->input('user_sts', '1'); // Default user_sts to '1'

        $pengguna = Pengguna::create($validated);

        $user = auth()->user();
           if ($user->role == 'superuser') {
        return redirect()->route('superuser.pengguna')
                ->with('success', 'Pengguna Berhasil Ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.pengguna')
                ->with('success', 'Pengguna Berhasil Ditambahkan');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show a specific user.
     */
    public function show($pengguna_id)
    {
        $pengguna = Pengguna::find($pengguna_id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tpengguna_idak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengguna berhasil diambil',
            'data' => $pengguna,
        ], 200);
    }

    /**
     * Update a specific user.
     */
         public function update(Request $request, $pengguna_id)
    {
        // Cari data berdasarkan jns_$pengguna_id
        $pengguna = Pengguna::find($pengguna_id);

        $user = auth()->user();
        if (!$pengguna) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna Tidak Ditemukan',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna Tidak Ditemukan',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }
        // Update data
        $pengguna->user_nama = $request->user_nama;
        $pengguna->role = $request->role;
        $pengguna->user_sts = $request->user_sts;
        $pengguna->save();

           if ($user->role == 'superuser') {
        return redirect()->route('superuser.pengguna')
                ->with('success', 'Pengguna Berhasil Diperbarui');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.pengguna')
                ->with('success', 'Pengguna Berhasil Diperbarui');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Menghapus data jenis barang.
     */
public function destroy($pengguna_id)
    {
        // Cari data berdasarkan pengguna_id
        $pengguna = Pengguna::find($pengguna_id);
        
        $user = auth()->user();
        if (!$pengguna) {
            if ($user->role == 'superuser') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna Tidak Ditemukan',
                ], 404);
            } elseif ($user->role == 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna Tidak Ditemukan',
                ], 403);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak',
                ], 403);
            }
        }

        // Hapus data
        $pengguna->delete();

           if ($user->role == 'superuser') {
        return redirect()->route('superuser.pengguna')
                ->with('success', 'Pengguna Berhasil Dihapus');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.pengguna')
                ->with('success', 'Pengguna Berhasil Dihapus');
       } else {
            abort(403, 'Unauthorized action.');
        }
    }
}