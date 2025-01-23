<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalian';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'kembali_id';
    protected $fillable = [
        'kembali_tgl',
        'kembali_sts'
    ];
}