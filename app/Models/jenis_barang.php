<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_barang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jenis_barang';

    protected $fillable = [
        'jns_brg_kode',
        'jns_barang_nama'
    ];
}