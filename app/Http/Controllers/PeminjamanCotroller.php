<?php

namespace App\Http\Controllers;

use App\Models\barang_inventaris;
use App\Models\peminjaman_barang;
use App\Models\Pengguna;
use App\Models\siswa;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\peminjaman;
use Log;

class PeminjamanCotroller extends Controller
{
 public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'pb_harus_kembali_tgl' => 'required',
            'pb_stat' => 'required', // Status peminjaman
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
        $peminjaman->user_id = auth()->id();
        $peminjaman->siswa_id = $request->siswa_id;
        $peminjaman->pb_harus_kembali_tgl = $request->pb_harus_kembali_tgl;
        $peminjaman->pb_tgl = now();
        $peminjaman->pb_stat = $request->pb_stat;
        $peminjaman->save();
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

  public function storeWithBarang(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'pb_stat' => 'required',
            'pb_harus_kembali_tgl' => 'required|date',
            'siswa_id' => 'required|exists:siswa,siswa_id', // Ensure siswa_id exists in the siswa table
            'barang' => 'required|array', // Ensure barang is an array
            'barang.*.br_kode' => 'required|string', // Each barang must have a br_kode
            'barang.*.pdb_sts' => 'required|string', // Each barang must have a pdb_sts
        ]);
        
        DB::beginTransaction(); // Start transaction
        
        try {
            // Generate pb_id for peminjaman
            $thn_sekarang = date('Y');
            $bln_sekarang = date('m');
            $lastPeminjaman = Peminjaman::whereRaw("SUBSTRING(pb_id, 3, 4) = ?", [$thn_sekarang])
                ->whereRaw("SUBSTRING(pb_id, 7, 2) = ?", [$bln_sekarang])
                ->orderBy('pb_id', 'desc')
                ->first();

            $lastNoUrutPb = $lastPeminjaman ? intval(substr($lastPeminjaman->pb_id, -3)) : 0;
            $newNoUrutPb = str_pad($lastNoUrutPb + 1, 3, '0', STR_PAD_LEFT);
            $pb_id_baru = "PB" . $thn_sekarang . $bln_sekarang . $newNoUrutPb;

            // Save peminjaman data
            $peminjaman = new Peminjaman();
            $peminjaman->pb_id = $pb_id_baru;
            $peminjaman->user_id = auth()->id();
            $peminjaman->siswa_id = $request->siswa_id;
            $peminjaman->pb_harus_kembali_tgl = $request->pb_harus_kembali_tgl;
            $peminjaman->pb_tgl = now();
            $peminjaman->pb_stat = $request->pb_stat;
            $peminjaman->save();

            // Save borrowed items
            foreach ($request->barang as $barang) {
                // Create a new peminjaman_barang record
                $peminjamanBarang = new Peminjaman_barang();
                
                // Generate pbd_id for peminjaman_barang
                $lastDetail = Peminjaman_barang::where('pb_id', $pb_id_baru)
                    ->orderBy('pbd_id', 'desc')
                    ->first();

                $lastNoUrut = $lastDetail ? intval(substr($lastDetail->pbd_id, -3)) : 0;
                $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

                $peminjamanBarang->pbd_id = "PJ" . $thn_sekarang . $bln_sekarang . substr($pb_id_baru, -3) . $newNoUrut;
                $peminjamanBarang->pb_id = $pb_id_baru; // Link to the peminjaman record
                $peminjamanBarang->br_kode = $barang['br_kode'];
                $peminjamanBarang->pdb_tgl = now();
                $peminjamanBarang->pdb_sts = $barang['pdb_sts'];
                $peminjamanBarang->save(); // Save the borrowed item
            }

            DB::commit(); // Commit transaction

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman dan barang berhasil disimpan',
                'data' => [
                    'pb_id' => $peminjaman->pb_id,
                    'barang' => $request->barang,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            Log::error($e->getMessage()); // Log the error for debugging
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan peminjaman',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Mengambil data barang inventaris dengan filter berdasarkan tahun.
     */
    public function index(Request $request)
    {

{
    $peminjaman = peminjaman::with('barang', 'siswa', 'pengguna', 'detail')->get();
    $user = auth()->user();
    $siswa = siswa::all(); // Fetch all siswa
    $pengguna = Pengguna::all(); // Fetch all pengguna
    $barang = barang_inventaris::all(); // Fetch all barang

    if ($user->role == 'superuser') {
        return view('superuser/Peminjaman/index', compact('peminjaman', 'siswa', 'pengguna', 'barang'));
    } elseif ($user->role == 'admin') {
        return view('admin/Peminjaman/index', compact('peminjaman', 'siswa', 'pengguna', 'barang'));
    } else {
        return view('user/Peminjaman/index', compact('peminjaman', 'siswa', 'pengguna', 'barang'));
    }
}
      
    }
        /**
     * Update data peminjaman berdasarkan pb_id.
     */
    public function update(Request $request, $pb_id)
    {
        // Cari data peminjaman berdasarkan pb_id
        $peminjaman = Peminjaman::where('pb_id', $pb_id)->first();

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        // Validasi input dari pengguna
        $validated = $request->validate([
            'pb_harus_kembali_tgl' => 'required',
            'pb_stat' => 'required',
        ]);

        // Update data peminjaman
        $peminjaman->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil diperbarui',
            'data' => $peminjaman,
        ]);
    }

    /**
     * Hapus data peminjaman berdasarkan pb_id.
     */
    public function destroy($pb_id)
    {
        // Cari data peminjaman berdasarkan pb_id
        $peminjaman = Peminjaman::where('pb_id', $pb_id)->first();

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        // Hapus data peminjaman
        $peminjaman->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil dihapus',
        ]);
    }

}