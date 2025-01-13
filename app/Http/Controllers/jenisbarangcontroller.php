<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\jenis_barang;

class JenisBarangController extends Controller
{
    /**
     * Menyimpan data jenis barang baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jns_brg_kode' => 'required|unique:jenis_barang,jns_brg_kode',
            'jns_barang_nama' => 'required|string|max:255',
        ]);

        // Menyimpan data jenis barang baru
        $jenisBarang = new jenis_barang();
        $jenisBarang->jns_brg_kode = $request->jns_brg_kode;
        $jenisBarang->jns_barang_nama = $request->jns_barang_nama;
        $jenisBarang->save();

        return response()->json([
            'success' => true,
            'message' => 'Jenis barang berhasil disimpan',
            'data' => $jenisBarang
        ]);
    }

    /**
     * Mengambil semua data jenis barang.
     */
    public function index()
    {
        // Ambil semua data jenis barang
        $data = jenis_barang::all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

}