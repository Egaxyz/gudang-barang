<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $table = 'siswa';

    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = 'siswa_id';

    protected $fillable = [
        'nama_siswa',
        'nis',
        'no_hp',
        'kelas_id',
        'jurusan_id'
    ];
}