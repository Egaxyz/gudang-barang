<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\barang_inventaris;

class Barang extends Controller
{
    /**
     * Menyimpan data barang inventaris baru.
     */
    public function store(Request $request)
    {
        
        // Dapatkan tahun saat ini
        $tahun = Carbon::now()->format('Y');

        // Dapatkan nomor urut terakhir berdasarkan tahun dari kolom br_tgl_entry
        $lastItem = barang_inventaris::whereYear('br_tgl_entry', $tahun)
            ->orderBy('br_kode', 'desc')
            ->first();

        $lastNoUrut = $lastItem ? intval(substr($lastItem->br_kode, -3)) : 0;
        $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

        // Buat kode barang baru
        $kodeBarangBaru = "INV" . $tahun . $newNoUrut;


        
        // Simpan data baru
        $barang = new barang_inventaris();
        $barang->br_kode = $kodeBarangBaru;
        $barang->id_asal_br = $request->id_asal_br;
        $barang->jns_brg_kode = $request->jns_brg_kode;
        $barang->user_id = $request->user_id;
        $barang->br_tgl_terima = $request->br_tgl_terima;
        $barang->br_tgl_entry = now();
        $barang->br_status = $request->br_status;
        $barang->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $barang
        ]);
    }

    /**
     * Mengambil data barang inventaris dengan filter berdasarkan tahun.
     */
    public function index(Request $request)
    {
        // Tahun default adalah tahun sekarang
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));

        // Ambil data berdasarkan tahun dari kolom br_tgl_entry
        $data = barang_inventaris::whereYear('br_tgl_entry', $tahun)
            ->orderBy('br_kode', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function update(Request $request, $br_kode)
    {
        // Cari data berdasarkan br_kode
        $barang = barang_inventaris::find($br_kode);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update data
        $barang->br_tgl_terima = $request->br_tgl_terima;
        $barang->br_tgl_entry = now();
        $barang->br_status = $request->br_status;
        $barang->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $barang
        ]);
    }

    /**
     * Menghapus data barang inventaris.
     */
    public function destroy($br_kode)
    {
        // Cari data berdasarkan br_kode
        $barang = barang_inventaris::find($br_kode);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}