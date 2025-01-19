<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asal_barang extends Model
{
    use HasFactory;

    protected $table = 'asal_barang';
    protected $primaryKey = 'id_asal_br';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nama_perusahaan',
        'jumlah_kirim',
        'tgl_kirim'
    ];
}