<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    public $table = 'siswa';

    public $timestamps = false;

    protected $fillable = [
        'nama_siswa',
        'nis',
        'no_hp',
        'kelas_id',
        'jurusan_id'
    ];
}