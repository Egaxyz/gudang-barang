<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenisBarangRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\jenis_barang;

class JenisBarangController extends Controller
{
    /**
     * Menyimpan data jenis barang baru.
     */
public function store(StoreJenisBarangRequest $request)
{
    $request->validate([
        'jns_barang_nama' => 'required',
        'tgl_entry' => 'required'
    ]);

    $tahun = Carbon::now()->format('Y');

    // Ambil nomor urut terakhir berdasarkan tahun
    $lastItem = jenis_barang::whereYear('tgl_entry', $tahun)
        ->orderBy('jns_brg_kode', 'desc')
        ->first();

    $lastNoUrut = $lastItem ? intval(substr($lastItem->jns_brg_kode, -3)) : 0;
    $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);
    $kodeJenisBarangBaru = "JB" . $tahun . $newNoUrut;

    // Simpan ke database
    $jenisBarang = new jenis_barang();
    $jenisBarang->jns_brg_kode = $kodeJenisBarangBaru;
    $jenisBarang->jns_barang_nama = $request->jns_barang_nama;
    $jenisBarang->tgl_entry = $request->tgl_entry;
    $jenisBarang->save();

    return redirect('jenis-barang')->with('success', 'Data Berhasil Ditambahkan');
}


    /**
     * Mengambil semua data jenis barang.
     */
    public function index()
    {
        // Ambil semua data jenis barang
        $data['jenis_barang'] = jenis_barang::get();
        $user = auth()->user();

        if ($user->role == 'superuser') {
            return view('superuser/Jenis_Barang/index', $data);
        } elseif($user->role == 'user') {
            return view('user/Jenis_Barang/index', $data);
        } else{
            return view('admin/Jenis_Barang/index', $data);
        }
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

            return redirect('jenis-barang')->with('success', 'Data Berhasil Diperbarui');
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

        return redirect('jenis-barang')->with('success', 'Data Berhasil Dihapus');
    }
    }