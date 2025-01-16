<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class konsentrasi extends Model
{
        use HasFactory;

    protected $table = 'konsentrasi';

    public $timestamps = false;

    protected $fillable = [
        'konsentrasi',
        'jurusan_id'
    ];
}