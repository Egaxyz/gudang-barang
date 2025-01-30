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
        $data['pengguna'] = Pengguna::get();

        return view('SuperUser/Pengguna.index')->with($data);
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

            return redirect('pengguna')->with('success', 'Data Berhasil Ditambahkan');
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

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Data tpengguna_idak ditemukan'
            ], 404);
        }

        // Update data
        $pengguna->user_nama = $request->user_nama;
        $pengguna->role = $request->role;
        $pengguna->user_sts = $request->user_sts;
        $pengguna->save();

            return redirect('pengguna')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Menghapus data jenis barang.
     */
public function destroy($pengguna_id)
    {
        // Cari data berdasarkan pengguna_id
        $pengguna = Pengguna::find($pengguna_id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $pengguna->delete();

            return redirect('pengguna')->with('success', 'Data Berhasil Dihapus');
    }
}