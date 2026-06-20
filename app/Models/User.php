<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class User extends Authenticatable
{
    protected $table = 'users';

   protected $fillable = [
    'username',
    'nama_lengkap',
    'first_name',
    'last_name',
    'email',
    'password',
    'role',
    'jenis_toko',
    'wilayah',
    'alamat',
    'no_telepon',
    'status',
    'otp_code',     // Tambahkan ini untuk kode OTP
    'is_active',
];
    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function reseller()
{
    return $this->hasOne(Reseller::class, 'user_id');
}
}
