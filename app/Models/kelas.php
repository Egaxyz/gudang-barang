<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tingkatan',
        'no_konsentrasi',
        'konsentrasi_id'
    ];
}