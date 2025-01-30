<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Models\asal_barang;
use App\Models\jenis_barang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\barang_inventaris;

class Barang extends Controller
{
    /**
     * Menyimpan data barang inventaris baru.
     */
    public function store(StoreBarangRequest $request)
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
        $barang->user_id = 1;
        $barang->br_tgl_terima = $request->br_tgl_terima;
        $barang->br_tgl_entry = $request->br_tgl_entry;
        $barang->br_status = $request->br_status;
        $barang->save();

                return redirect('barang')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Mengambil data barang inventaris dengan filter berdasarkan tahun.
     */
public function index(Request $request)
{
    $tahun = $request->input('tahun', Carbon::now()->format('Y'));

    // Ambil data barang inventaris
    $barangInventaris = barang_inventaris::with('jenisBarang', 'asalBarang')->get();

    // Ambil data asal barang & jenis barang
    $asal_barang = asal_barang::all();
    $jenis_barang = jenis_barang::all();

    return view('SuperUser/Barang/index', [
        'barang_inventaris' => $barangInventaris,
        'asal_barang' => $asal_barang,
        'jenis_barang' => $jenis_barang
    ]);
}


// Untuk laporan barang
public function laporan(Request $request)
{
    // Tahun default adalah tahun sekarang
    $tahun = $request->input('tahun', Carbon::now()->format('Y'));

    // Ambil data berdasarkan tahun dari kolom br_tgl_entry
    $dataByYear = barang_inventaris::whereYear('br_tgl_entry', $tahun)
        ->orderBy('br_kode', 'asc')
        ->get();

    // Mengambil seluruh data barang dan relasi dengan jenisBarang dan asalBarang
    $barangInventaris = barang_inventaris::with('jenisBarang', 'peminjamanBarang')
       ->leftJoin('peminjaman_barang', 'barang_inventaris.br_kode', '=', 'peminjaman_barang.br_kode')
        ->select('barang_inventaris.*')
        ->where(function ($query) {
            $query->whereNull('peminjaman_barang.pdb_sts') // Barang yang belum dipinjam
                  ->orWhere('peminjaman_barang.pdb_sts', 'tersedia'); // Status 'tersedia'
        })
        ->get();

    // Kirim data ke view laporan barang dengan tampilan yang lebih khusus
    return view('SuperUser/Laporan_Barang/index', [
        'dataByYear' => $dataByYear,
        'barang_inventaris' => $barangInventaris
    ]);
}
public function barang_belum_kembali(Request $request)
{
    // Tahun default adalah tahun sekarang
    $tahun = $request->input('tahun', Carbon::now()->format('Y'));

    // Ambil data berdasarkan tahun dari kolom br_tgl_entry
    $dataByYear = barang_inventaris::whereYear('br_tgl_entry', $tahun)
        ->orderBy('br_kode', 'asc')
        ->get();

    // Mengambil seluruh data barang dan relasi dengan jenisBarang dan asalBarang
   $barangInventaris = barang_inventaris::with('jenisBarang', 'peminjamanBarang')
   ->leftJoin('peminjaman_barang', 'barang_inventaris.br_kode', '=', 'peminjaman_barang.br_kode')
   ->select('barang_inventaris.*')
   ->where('peminjaman_barang.pdb_sts', 'dipinjam') // Filter hanya barang dengan status 'dipinjam'
   ->get();


    // Kirim data ke view laporan barang dengan tampilan yang lebih khusus
    return view('SuperUser/Barang_Belum_Kembali/index', [
        'dataByYear' => $dataByYear,
        'barang_inventaris' => $barangInventaris
    ]);
}

   public function update(Request $request, $br_kode)
{
    // Cari data berdasarkan br_kode menggunakan model barang_inventaris
    $barang = barang_inventaris::findOrFail($br_kode);

    // Update data
    $barang->id_asal_br = $request->id_asal_br;
    $barang->jns_brg_kode = $request->jns_brg_kode;
    $barang->br_tgl_terima = $request->br_tgl_terima;
    $barang->br_tgl_entry = $request->br_tgl_entry;
    $barang->br_status = $request->br_status;
    $barang->save();

    return redirect('barang')->with('success', 'Data Berhasil Diperbarui');
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

                return redirect('barang')->with('success', 'Data Berhasil Dihapus');
    }
}