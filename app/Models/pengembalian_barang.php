<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalian_barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kembali_tgl',
        'kembali_sts'
    ];
}