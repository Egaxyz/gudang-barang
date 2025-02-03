<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsalBarangRequest;
use App\Models\asal_barang;
use Carbon\Carbon;
use Illuminate\Http\Request;


class Barang_Asal_Controller extends Controller
{
    /**
     * Menyimpan data barang inventaris baru.
     */
    public function store(StoreAsalBarangRequest $request)
    {
        // Dapatkan tahun saat ini
        $tahun = Carbon::now()->format('Y');

        // Dapatkan nomor urut terakhir berdasarkan tahun dari kolom tgl_kirim
        $lastItem = asal_barang::whereYear('tgl_kirim', $tahun)
            ->orderBy('id_asal_br', 'desc')
            ->first();

        $lastNoUrut = $lastItem ? intval(substr($lastItem->id_asal_br, -3)) : 0;
        $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

        // Buat kode barang baru
        $kodeBarangBaru = "AB" . $tahun . $newNoUrut;

        // Simpan data baru
        $asalbarang = new asal_barang();
        $asalbarang->id_asal_br = $kodeBarangBaru;
        $asalbarang->nama_perusahaan = $request->nama_perusahaan;
        $asalbarang->jumlah_kirim = $request->jumlah_kirim;
        $asalbarang->tgl_kirim = now();

        $asalbarang->save();

        $request->validate([
            'nama_perusahaan' => 'required',
            'jumlah_kirim' => 'required',
            'tgl_kirim' => 'required',
        ]);

        return redirect('asal-barang')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Mengambil data barang inventaris dengan filter berdasarkan tahun.
     */
    public function index(Request $request)
    {
        // Tahun default adalah tahun sekarang
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));

        // Ambil data berdasarkan tahun dari kolom tgl_kirim
        $data['asal_barang'] = asal_barang::get();

        $user = auth()->user();

        if ($user->role == 'superuser') {
            return view('superuser/Asal_Barang/index', $data);
        } else  {
            return view('user/Asal_Barang/index', $data);
        }
    }

    /**
     * Mengupdate data barang inventaris.
     */
    public function update(Request $request, $id_asal_br)
    {
        // Cari data berdasarkan id_asal_br
        $asalbarang = asal_barang::find($id_asal_br);

        if (!$asalbarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update data
        $asalbarang->nama_perusahaan = $request->nama_perusahaan;
        $asalbarang->jumlah_kirim = $request->jumlah_kirim;
        $asalbarang->tgl_kirim = $request->tgl_kirim;
        $asalbarang->save();

        return redirect('asal-barang')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Menghapus data barang inventaris.
     */
    public function destroy($id_asal_br)
    {
        // Cari data berdasarkan id_asal_br
        $asalbarang = asal_barang::find($id_asal_br);

        if (!$asalbarang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $asalbarang->delete();
        return redirect('asal-barang');
    }
}