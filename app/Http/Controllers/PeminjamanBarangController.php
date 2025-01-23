<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman_barang;
use App\Models\peminjaman;

class PeminjamanBarangController extends Controller
{
    /**
     * Menyimpan data peminjaman barang.
     */
    public function store(Request $request)
{
    // Validasi input dari pengguna
    $request->validate([
        'br_kode' => 'required|string', // Kode barang
        'pdb_sts' => 'required|string',  // Status peminjaman
        'pdb_tgl' => 'required'
    ]);
    $barangDipinjam = Peminjaman_barang::where('br_kode', $request->br_kode)
        ->where('pdb_sts', 'dipinjam') 
        ->first();

    if ($barangDipinjam) {
        return response()->json([
            'success' => false,
            'message' => 'Barang sedang dipinjam dan tidak dapat dipinjam bersamaan',
        ], 400);
    }

    // Debugging: Fetch the latest pb_id
    $peminjamanTerbaru = Peminjaman_barang::orderBy('pb_id', 'desc')->first();

    if (!$peminjamanTerbaru) {
        // Debugging: Log all records to verify data structure
        $allRecords = Peminjaman_barang::all();
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada data peminjaman ditemukan, meskipun data ada.',
            'debug_data' => $allRecords,
        ], 404);
    }

    $pb_id = $peminjamanTerbaru->pb_id;

    // Tahun dan bulan saat ini
    $thn_sekarang = date('Y');
    $bln_sekarang = date('m');

    // Ambil nomor urut terakhir untuk ID detail peminjaman (pbd_id) berdasarkan pb_id
    // Ambil nomor urut terakhir untuk ID detail peminjaman (pbd_id) berdasarkan pb_id
$lastDetail = Peminjaman_barang::where('pb_id', $pb_id)
    ->orderBy('pbd_id', 'desc')
    ->first();

// Tentukan nomor urut baru untuk pbd_id
$lastNoUrut = $lastDetail ? intval(substr($lastDetail->pbd_id, -3)) : 0;
$newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

// Simpan data peminjaman barang dengan pb_id yang sudah ada
$peminjamanBarang = new Peminjaman_barang();
$peminjamanBarang->pbd_id = "PJ" . $thn_sekarang . $bln_sekarang . substr($pb_id, -3) . $newNoUrut;
$peminjamanBarang->pb_id = $pb_id;  // Gunakan pb_id yang sudah ada
$peminjamanBarang->br_kode = $request->br_kode;
$peminjamanBarang->pdb_tgl = now();
$peminjamanBarang->pdb_sts = $request->pdb_sts;
$peminjamanBarang->save();


    return response()->json([
        'success' => true,
        'message' => 'Data detail peminjaman berhasil disimpan',
        'data' => $peminjamanBarang
    ]);
}
    /*
     * Menampilkan semua data peminjaman barang.
     */
    public function index()
{
    // Ambil semua data dari tabel Peminjaman_barang
    $data = Peminjaman_barang::orderBy('pdb_tgl', 'desc')->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

public function update(Request $request, $pbd_id)
    {
        // Validasi input
        $request->validate([
            'pdb_tgl' => 'required', // Kode barang
        ]);

        // Cari data berdasarkan pbd_id
        $peminjamanBarang = Peminjaman_barang::where('pbd_id', $pbd_id)->first();

        if (!$peminjamanBarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman barang tidak ditemukan.',
            ], 404);
        }

        // Perbarui data jika ada input baru
        if ($request->has('pdb_tgl')) {
            $peminjamanBarang->pdb_tgl = $request->pdb_tgl;
        }

        $peminjamanBarang->save();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman barang berhasil diperbarui.',
            'data' => $peminjamanBarang
        ]);
    }

    /**
     * Menghapus data peminjaman barang.
     */
    public function destroy($pbd_id)
    {
        // Cari data berdasarkan pbd_id
        $peminjamanBarang = Peminjaman_barang::where('pbd_id', $pbd_id)->first();

        if (!$peminjamanBarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman barang tidak ditemukan.',
            ], 404);
        }

        // Hapus data
        $peminjamanBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman barang berhasil dihapus.'
        ]);
    }
}