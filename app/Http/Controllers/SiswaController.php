<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa;

class SiswaController extends Controller
{
    /**
     * Get all siswa.
     */
    public function index()
    {
        $siswa = siswa::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar siswa berhasil diambil',
            'data' => $siswa,
        ], 200);
    }

    /**
     * Store a new siswa.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' =>  'required',
            'nis'=>'required',
            'no_hp'=>'required',
            'kelas_id'=>'required',
            'jurusan_id'=>'required'
        ]);

        $siswa = siswa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'siswa berhasil ditambahkan',
            'data' => $siswa,
        ], 201);
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

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'siswa tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'siswa' => 'required|string|max:100',
        ]);

        $siswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'siswa berhasil diperbarui',
            'data' => $siswa,
        ], 200);
    }

    /**
     * Delete a specific siswa.
     */
    public function destroy($id)
    {
        $siswa = siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'siswa tidak ditemukan',
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'siswa berhasil dihapus',
        ], 200);
    }
}