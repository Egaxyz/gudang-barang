<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsentrasi;

class KonsentrasiController extends Controller
{
    /**
     * Get all konsentrasi.
     */
    public function index()
    {
        $konsentrasi = konsentrasi::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar konsentrasi berhasil diambil',
            'data' => $konsentrasi,
        ], 200);
    }

    /**
     * Store a new konsentrasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' =>'required',
            'konsentrasi' => 'required|string|max:20',
        ]);

        $konsentrasi = konsentrasi::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'konsentrasi berhasil ditambahkan',
            'data' => $konsentrasi,
        ], 201);
    }

    /**
     * Show a specific konsentrasi.
     */
    public function show($id)
    {
        $konsentrasi = konsentrasi::find($id);

        if (!$konsentrasi) {
            return response()->json([
                'success' => false,
                'message' => 'konsentrasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail konsentrasi berhasil diambil',
            'data' => $konsentrasi,
        ], 200);
    }

    /**
     * Update a specific konsentrasi.
     */
    public function update(Request $request, $id)
    {
        $konsentrasi = konsentrasi::find($id);

        if (!$konsentrasi) {
            return response()->json([
                'success' => false,
                'message' => 'konsentrasi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'konsentrasi' => 'required|string|max:100',
        ]);

        $konsentrasi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'konsentrasi berhasil diperbarui',
            'data' => $konsentrasi,
        ], 200);
    }

    /**
     * Delete a specific konsentrasi.
     */
    public function destroy($id)
    {
        $konsentrasi = konsentrasi::find($id);

        if (!$konsentrasi) {
            return response()->json([
                'success' => false,
                'message' => 'konsentrasi tidak ditemukan',
            ], 404);
        }

        $konsentrasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'konsentrasi berhasil dihapus',
        ], 200);
    }
}