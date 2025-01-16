<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all users.
     */
    public function index()
    {
        $users = Pengguna::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil diambil',
            'data' => $users,
        ], 200);
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_nama' => 'required|max:50',
            'user_pass' => 'required|min:8',
            'role' => 'required|in:superuser,admin,user,siswa',
        ]);

        $validated['user_pass'] = bcrypt($validated['user_pass']); // Hash password
        $validated['user_sts'] = $request->input('user_sts', '1'); // Default user_sts to '1'

        $pengguna = Pengguna::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil disimpan',
            'data' => $pengguna,
        ], 201);
    }

    /**
     * Show a specific user.
     */
    public function show($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
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
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'user_nama' => 'required|max:50',
            'role' => 'required|in:superuser,admin,user,siswa',
            'user_sts' => 'required|in:0,1',
        ]);

        // Jika password diberikan, validasi dan perbarui
        if ($request->has('user_pass') && $request->user_pass) {
            $validated['user_pass'] = bcrypt($request->user_pass);
        }

        $pengguna->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $pengguna,
        ], 200);
    }

    /**
     * Delete a specific user.
     */
    public function destroy($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        $pengguna->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus',
        ], 200);
    }
}