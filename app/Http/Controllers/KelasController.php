<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kelas;

class KelasController extends Controller
{
    /**
     * Get all kelas.
     */
    public function index()
    {
        $kelas = kelas::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelas berhasil diambil',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Store a new kelas.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkatan' => 'required',
            'no_konsentrasi'=>'required',
            'konsentrasi_id'=>'required'
        ]);

        $kelas = kelas::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'kelas berhasil ditambahkan',
            'data' => $kelas,
        ], 201);
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
                'message' => 'kelas tidak ditemukan',
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
    public function update(Request $request, $id)
    {
        $kelas = kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'kelas tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'kelas' => 'required|string|max:100',
        ]);

        $kelas->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'kelas berhasil diperbarui',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Delete a specific kelas.
     */
    public function destroy($id)
    {
        $kelas = kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'kelas tidak ditemukan',
            ], 404);
        }

        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'kelas berhasil dihapus',
        ], 200);
    }
}