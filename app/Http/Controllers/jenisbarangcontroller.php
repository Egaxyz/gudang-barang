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
        $tahun = Carbon::now()->format('Y');

        // Dapatkan nomor urut terakhir berdasarkan tahun dari kolom br_tgl_entry
        $lastItem = jenis_barang::whereYear('tgl_entry', $tahun)
            ->orderBy('jns_brg_kode', 'desc')
            ->first();

        $lastNoUrut = $lastItem ? intval(substr($lastItem->jns_brg_kode, -3)) : 0;
        $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

        // Buat kode barang baru
        $kodeJenisBarangBaru = "JB" . $tahun . $newNoUrut;

        // Menyimpan data jenis barang baru
        $jenisBarang = new jenis_barang();
        $jenisBarang->jns_brg_kode = $kodeJenisBarangBaru;
        $jenisBarang->jns_barang_nama = $request->jns_barang_nama;
        $jenisBarang->tgl_entry = $request->tgl_entry;
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
    $data['jenis_barang'] = jenis_barang::get();

    return view('SuperUser/Jenis Barang/index')->with($data);
    }

    /**
     * Mengupdate data jenis barang.
     */
     public function update(Request $request, $jns_brg_kode)
    {
        // Cari data berdasarkan jns_$jns_brg_kode
        $jenisBarang = jenis_barang::find($jns_brg_kode);

        if (!$jenisBarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update data
        $jenisBarang->jns_barang_nama = $request->jns_barang_nama;
        $jenisBarang->tgl_entry = $request->tgl_entry;
        $jenisBarang->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $jenisBarang
        ]);
    }

    /**
     * Menghapus data jenis barang.
     */
public function destroy($jns_brg_kode)
    {
        // Cari data berdasarkan jns_brg_kode
        $jenisBarang = jenis_barang::find($jns_brg_kode);

        if (!$jenisBarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $jenisBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
    }