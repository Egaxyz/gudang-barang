<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = "kelas_id";

    protected $fillable = [
        'tingkatan',
        'no_konsentrasi',
        'konsentrasi',
        'jurusan_id'
    ];
}