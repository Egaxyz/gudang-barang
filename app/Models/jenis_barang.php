<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class jenis_barang extends Model
{
    use HasFactory, HasRoles;

    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'jenis_barang';
    public $primaryKey = 'jns_brg_kode';

    protected $fillable = [
        'jns_barang_nama',
        'tgl_entry'
    ];
    public function barangInventaris()
{
    return $this->hasMany(barang_inventaris::class, 'jns_brg_kode', 'jns_brg_kode');
}

}