<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\peminjaman;

class PeminjamanCotroller extends Controller
{
 public function store(Request $request)
{
    // Validasi input dari pengguna
    $request->validate([
        'pb_stat' => 'required|string|max:2', // Status peminjaman
    ]);

    // Tahun dan bulan saat ini
    $thn_sekarang = date('Y');
    $bln_sekarang = date('m');

    // Ambil nomor urut terakhir untuk ID transaksi peminjaman (pb_id)
    $lastPeminjaman = Peminjaman::whereRaw("SUBSTRING(pb_id, 3, 4) = ?", [$thn_sekarang])
        ->whereRaw("SUBSTRING(pb_id, 7, 2) = ?", [$bln_sekarang])
        ->orderBy('pb_id', 'desc')
        ->first();

    // Tentukan nomor urut baru untuk pb_id
    $lastNoUrutPb = $lastPeminjaman ? intval(substr($lastPeminjaman->pb_id, -3)) : 0;
    $newNoUrutPb = str_pad($lastNoUrutPb + 1, 3, '0', STR_PAD_LEFT);
    $pb_id_baru = "PB" . $thn_sekarang . $bln_sekarang . $newNoUrutPb;

    // Simpan data peminjaman
    $peminjaman = new Peminjaman();
    $peminjaman->pb_id = $pb_id_baru;
    $peminjaman->siswa_id = $request->siswa_id;
    $peminjaman->pb_nama_siswa = $request->pb_no_siswa;
    $peminjaman->pb_no_siswa = $request->pb_no_siswa;
    $peminjaman->pb_harus_kembali_tgl = $request->pb_harus_kembali_tgl;
    $peminjaman->pb_tgl = now();
    $peminjaman->pb_stat = $request->pb_stat;
    $peminjaman->save();

    

    // Mengembalikan pb_id yang telah disimpan
    return response()->json([
        'success' => true,
        'message' => 'Peminjaman berhasil disimpan',
        'data' => [
            'pb_id' => $peminjaman->pb_id,
            'siswa_id' => $peminjaman->siswa_id,
            'pb_harus_kembali_tgl' => $peminjaman->pb_harus_kembali_tgl,
            'pb_tgl' => $peminjaman->pb_tgl,
            'pb_stat' => $peminjaman->pb_stat,
        ]
    ]);
}

    /**
     * Mengambil data barang inventaris dengan filter berdasarkan tahun.
     */
    public function index(Request $request)
    {
        // Tahun default adalah tahun sekarang
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));
        $bulan = $request->input('bulan',Carbon::now()->format('m'));
        // Ambil data berdasarkan tahun dari kolom br_tgl_entry
        $data = peminjaman::whereYear('pb_tgl', $tahun)
            ->whereMonth('pb_tgl', $bulan)
            ->orderBy('pb_id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}