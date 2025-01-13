<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    public $timestamps = false;

    protected $fillable = [
        'pb_tgl',
        'pb_no_siswa',
        'pb_nama_siswa',
        'pb_harus_kembali_tgl',
        'pb_stat'
    ];
}