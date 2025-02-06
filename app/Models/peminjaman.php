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
        'pb_harus_kembali_tgl',
        'pb_stat'
    ];

    public function detail()
{
    return $this->belongsTo(peminjaman_barang::class, 'pb_id', 'pb_id');
}
    public function siswa()
{
    return $this->belongsTo(siswa::class, 'siswa_id');
}
  public function barang()
    {
        return $this->belongsTo(barang_inventaris::class, 'br_kode', 'br_kode');
    }
    public function pengguna()
    {
            {
        return $this->belongsTo(Pengguna::class, 'user_id', 'user_id');
    }
    }
    public function asal_barang()
    {
            {
        return $this->belongsTo(asal_barang::class, 'br_kode', 'br_kode');
    }
    }
    public function jenis_barang()
    {
            {
        return $this->belongsTo(jenis_barang::class, 'br_kode', 'br_kode');
    }
    }
}