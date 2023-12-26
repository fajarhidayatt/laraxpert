<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/// [Login multiple table] 1. ubah model menjadi extends ke `Authenticatable`
class Staff extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'fullname',
        'username',
        'address',
        'role',
        'password'
    ];

    /// password auto hash ketika create data
    protected $casts = [
        'password' => 'hashed',
    ];

    /// menyembunyikan column password saat mengakses data staff
    protected $hidden = [
        'password',
    ];
}
