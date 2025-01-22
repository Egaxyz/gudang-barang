<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_barang extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'jenis_barang';
    public $primaryKey = 'jns_brg_kode';

    protected $fillable = [
        'jns_barang_nama',
        'tgl_entry'
    ];
}