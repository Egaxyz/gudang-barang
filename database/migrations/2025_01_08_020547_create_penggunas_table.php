<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna; // Pastikan model sudah ada dan sesuai dengan nama tabel 'penggunas'

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        // Mengambil semua data pengguna dari tabel penggunas
        $users = Pengguna::all();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Menambahkan pengguna baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_pass' => 'required|string|min:6',
            'role' => 'required|in:superuser,admin,user',
            'user_sts' => 'required|in:0,1',
        ]);

        // Membuat pengguna baru tanpa menyertakan user_id (karena auto increment)
        $user = new Pengguna();
        $user->user_nama = $request->user_nama;
        $user->user_pass = bcrypt($request->user_pass); // Enkripsi password
        $user->role = $request->role;
        $user->user_sts = $request->user_sts;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan',
            'data' => $user
        ]);
    }

    /**
     * Menampilkan detail pengguna berdasarkan user_id.
     */
    public function show($user_id)
    {
        // Mencari pengguna berdasarkan user_id
        $user = Pengguna::find($user_id);

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $user_id)
    {
        // Validasi input
        $validated = $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_pass' => 'nullable|string|min:6', // Password opsional jika tidak diubah
            'role' => 'required|in:superuser,admin,user',
            'user_sts' => 'required|in:0,1',
        ]);

        // Mencari pengguna berdasarkan user_id
        $user = Pengguna::find($user_id);

        if ($user) {
            // Update data pengguna
            $user->user_nama = $request->user_nama;
            if ($request->has('user_pass') && $request->user_pass) {
                $user->user_pass = bcrypt($request->user_pass); // Enkripsi password
            }
            $user->role = $request->role;
            $user->user_sts = $request->user_sts;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil diperbarui',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }
    }

    /**
     * Menghapus pengguna berdasarkan user_id.
     */
    public function destroy($user_id)
    {
        // Mencari pengguna berdasarkan user_id
        $user = Pengguna::find($user_id);

        if ($user) {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }
    }
}