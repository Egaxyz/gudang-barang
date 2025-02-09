<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class pengembalian extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'pengembalian';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'kembali_id';
    protected $fillable = [
        'kembali_tgl',
        'kembali_sts'
    ];
    public function pengguna()
{
    return $this->belongsTo(pengguna::class, 'user_id');
}
   public function peminjaman()
{
    return $this->belongsTo(peminjaman::class, 'pb_id');
}
}