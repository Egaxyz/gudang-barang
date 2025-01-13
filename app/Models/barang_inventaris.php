<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_inventaris extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'br_tgl_terima',
        'br_tgl_entry',
        'br_status'
    ];
}