<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;

    // Menghubungkan ke tabel 'reseller' di phpMyAdmin
    protected $table = 'reseller';
    
    // Matikan jika tabelmu tidak punya kolom created_at dan updated_at
    public $timestamps = false;

    // Kolom yang diizinkan untuk diisi data (Sesuaikan dengan phpMyAdmin)
    protected $fillable = [
        'nama_lengkap', // Sesuai dengan tampilan web tabel Reseller kamu
        'jenis_toko',
        'wilayah',
        'alamat',
        'no_telepon',
        'status'
    ];

    // Hubungan (Relasi) jika reseller terhubung dengan tabel User (opsional jika dipakai)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}