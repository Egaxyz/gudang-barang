<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman_barang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barang';
    public $incrementing = false;
    protected $primaryKey = 'pbd_id';
    public $timestamps = false;
    protected $fillable = [
        'br_kode',
        'pdb_sts',
        'pdb_tgl'
    ];
    public function barangInventaris()
{
    return $this->hasMany(barang_inventaris::class, 'br_kode', 'br_kode');
}
// PeminjamanBarang.php (Model)
public function peminjaman()
{
    return $this->belongsTo(Peminjaman::class, 'pb_id');
}

public function siswa()
{
    return $this->belongsTo(siswa::class, 'siswa_id');
}

}