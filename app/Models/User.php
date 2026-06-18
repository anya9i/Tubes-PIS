<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use HasFactory;


class User extends Authenticatable
{
    protected $table = 'users';

   protected $fillable = [
    'username',
    'nama_lengkap',
    'email',
    'password',
    'role',
    'jenis_toko',
    'wilayah',
    'alamat',
    'no_telepon',
    'status',
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
