<?php

namespace App\Http\Controllers;

use App\Models\peminjaman;
use App\Models\pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Peminjaman_barang;

class PengembalianController extends Controller
{
    /**
     * Proses pengembalian barang.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pb_id' => 'required',  // ID peminjaman
        ]);

        \Log::info('Request data:', $request->all());

        // Cari data peminjaman barang berdasarkan br_kode dan pb_id
        $peminjamanBarang = Peminjaman_barang::where('pb_id', $request->pb_id)
            ->where('pdb_sts', 'dipinjam')
            ->first();

        if (!$peminjamanBarang) {
            \Log::warning('Item not found or not borrowed', ['pb_id' => $request->pb_id]);
            return response()->json([
                'success' => false,
                'message' => 'Barang dengan kode ini tidak ditemukan atau tidak sedang dipinjam.',
            ], 404);
        }

        // Perbarui status barang menjadi 'tersedia'
        $peminjamanBarang->pdb_sts = 'tersedia';
        $peminjamanBarang->save();

          $thn_sekarang = date('Y');
          $bln_sekarang = date('m');

    // Ambil nomor urut terakhir untuk ID transaksi peminjaman (pb_id)
    $lastPengembalian = pengembalian::whereRaw("SUBSTRING(pb_id, 3, 4) = ?", [$thn_sekarang])
        ->whereRaw("SUBSTRING(pb_id, 7, 2) = ?", [$bln_sekarang])
        ->orderBy('kembali_id', 'desc')
        ->first();

    // Tentukan nomor urut baru untuk pb_id
    $lastNoUrutPb = $lastPengembalian ? intval(substr($lastPengembalian->kembali_id, -3)) : 0;
    $newNoUrutKb = str_pad($lastNoUrutPb + 1, 3, '0', STR_PAD_LEFT);
    $kembali_id_baru = "KB" . $thn_sekarang . $bln_sekarang . $newNoUrutKb;


          // Masukkan data pengembalian ke tabel 'pengembalian'
    $pengembalian = new pengembalian();
    $pengembalian->kembali_id = $kembali_id_baru;
    $pengembalian->pb_id = $request->pb_id;
    $pengembalian->user_id = auth()->id();
    $pengembalian->kembali_tgl = $request->kembali_tgl;
    $pengembalian->kembali_sts = '1';
    $pengembalian->save();

   $user = auth()->user();
           if ($user->role == 'superuser') {
        return redirect()->route('superuser.pengembalian')
                ->with('success', 'Pengembalian Berhasil Ditambahkan');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian Berhasil Ditambahkan');
       } elseif($user->role=='user'){
            return redirect()->route('user.pengembalian')
                ->with('success', 'Pengembalian Berhasil Ditambahkan');
       }else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Menampilkan daftar barang yang telah dikembalikan.
     */
   public function index(Request $request)
{
    // Ambil semua data peminjaman
    $peminjaman = peminjaman::all();
    
    // Ambil tahun dari request atau gunakan tahun saat ini
    $tahun = $request->input('tahun', Carbon::now()->format('Y'));
    
    // Ambil data pengembalian
    $data['pengembalian'] = pengembalian::all(); // Gunakan all() untuk mengambil semua data
    
    // Ambil user yang sedang login
    $user = auth()->user();

    // Siapkan data untuk dikirim ke view
    $data['peminjaman'] = $peminjaman; // Tambahkan peminjaman ke data

    // Kembalikan view berdasarkan role user
    if ($user->role == 'superuser') {
        return view('superuser.Pengembalian.index', $data);
    } elseif ($user->role == 'user') {
        return view('user.Pengembalian.index', $data);
    } else {
        return view('admin.Pengembalian.index', $data);
    }
}

   public function laporan(Request $request)
{
    // Ambil semua data peminjaman
    $peminjaman = peminjaman::all();
    
    // Ambil tahun dari request atau gunakan tahun saat ini
    $tahun = $request->input('tahun', Carbon::now()->format('Y'));
    
    // Ambil data pengembalian
    $data['pengembalian'] = pengembalian::all(); // Gunakan all() untuk mengambil semua data
    
    // Ambil user yang sedang login
    $user = auth()->user();

    // Siapkan data untuk dikirim ke view
    $data['peminjaman'] = $peminjaman; // Tambahkan peminjaman ke data

    // Kembalikan view berdasarkan role user
    if ($user->role == 'superuser') {
        return view('superuser.Laporan_Pengembalian.index', $data);
    } elseif ($user->role == 'user') {
        return view('user.Laporan_Pengembalian.index', $data);
    } else {
        return view('admin.Laporan_Pengembalian.index', $data);
    }
}
    /**
     * Memperbarui data pengembalian barang.
     */
  public function update(Request $request, $kembali_id)
{
    $request->validate([
        'kembali_tgl' => 'required',
        'kembali_sts' => 'required',
    ]);

    $pengembalian = pengembalian::find($kembali_id);

    if (!$pengembalian) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan.',
        ], 404);
    }

    $pengembalian->update([
        'kembali_tgl' => $request->kembali_tgl,
        'kembali_sts' => $request->kembali_sts,
    ]);

    // Ambil data terbaru dari database
    $updatedData = pengembalian::find($kembali_id);

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diperbarui.',
        'data' => $updatedData, // Return data terbaru
    ]);
}


    /**
     * Menghapus data pengembalian barang.
     */
    public function destroy($kembali_id)
    {
        // Cari data berdasarkan ID
        $pengembalian = pengembalian::find($kembali_id);

        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Hapus data
        $pengembalian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}