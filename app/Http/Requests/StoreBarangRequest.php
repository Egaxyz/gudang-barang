<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan bisa diakses oleh semua user
    }

    public function rules()
    {
        return [
            'id_asal_br' => 'required|exists:asal_barang,id_asal_br',
            'jns_brg_kode' => 'required|exists:jenis_barang,jns_brg_kode',
            'br_tgl_terima' => 'required|date',
            'br_tgl_entry' => 'required|date',
            'br_status' => 'required|integer|in:0,1,2,3', // Hanya boleh 0,1,2,3
        ];
    }

    public function messages()
    {
        return [
            'id_asal_br.required' => 'Asal Barang harus dipilih.',
            'jns_brg_kode.required' => 'Jenis Barang harus dipilih.',
            'br_tgl_terima.required' => 'Tanggal Terima harus diisi.',
            'br_tgl_entry.required' => 'Tanggal Entry harus diisi.',
            'br_status.in' => 'Status barang harus antara 0, 1, 2, atau 3.',
        ];
    }
}