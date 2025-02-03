<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = "pengguna";
    protected $primaryKey = "user_id";

    protected $fillable = [
        'user_nama',
        'user_pass',
        'role',
        'user_sts'
    ];

    public $timestamps = false;

    /**
     * Set password agar selalu di-hash saat disimpan
     */
    public function setUserPassAttribute($value)
    {
        $this->attributes['user_pass'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    /**
     * Mengecek apakah pengguna aktif
     */
    public function isActive()
    {
        return $this->user_sts == 1;
    }
}