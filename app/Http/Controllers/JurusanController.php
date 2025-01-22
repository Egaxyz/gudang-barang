<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    /**
     * Get all jurusan.
     */
    public function index()
    {
        $jurusan = Jurusan::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar jurusan berhasil diambil',
            'data' => $jurusan,
        ], 200);
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

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil ditambahkan',
            'data' => $jurusan,
        ], 201);
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
                'message' => 'Jurusan tidak ditemukan',
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

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'jurusan' => 'required|string|max:100',
        ]);

        $jurusan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil diperbarui',
            'data' => $jurusan,
        ], 200);
    }

    /**
     * Delete a specific jurusan.
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan',
            ], 404);
        }

        $jurusan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil dihapus',
        ], 200);
    }
}