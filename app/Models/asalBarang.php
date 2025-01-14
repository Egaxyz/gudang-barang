<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asalBarang extends Model
{
    use HasFactory;

    protected $table = 'asal_barang';

    public $timestamps = false;

    protected $fillable = [
        'nama_perusahaan',
        'jumlah_kirim',
        'tgl_kirim'
    ];
}