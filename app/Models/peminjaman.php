<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class peminjaman extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'peminjaman';

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'pb_id';

    protected $fillable = [
        'pb_tgl',
        'pb_nis_siswa',
        'pb_nama_siswa',
        'pb_harus_kembali_tgl',
        'pb_stat'
    ];
    public function siswa()
{
    return $this->belongsTo(siswa::class, 'siswa_id');
}
}