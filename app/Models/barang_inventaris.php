<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_inventaris extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = "br_kode";
    public $incrementing = false;
    protected $fillable = [
        'br_tgl_terima',
        'br_tgl_entry',
        'br_status'
    ];


      public function jenisBarang()
    {
        return $this->belongsTo(jenis_barang::class, 'jns_brg_kode', 'jns_brg_kode');
    }
    public function asalBarang()
    {
        return $this->belongsTo(asal_barang::class, 'id_asal_br', 'id_asal_br');
    }
    public function detail()
    {
        return $this->belongsTo(peminjaman_barang::class, 'br_kode', 'br_kode');
    }
}