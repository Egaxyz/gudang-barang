<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman_barang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barang';

    public $timestamps = false;
    protected $fillable = [
        'br_kode',
        'pdb_sts'
    ];
}