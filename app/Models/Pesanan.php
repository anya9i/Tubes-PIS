<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    // Menentukan nama tabel karena nama tabelmu 'pesanan' (bukan 'pesanans')
    protected $table = 'pesanan';

    // Kolom yang boleh diisi (Mass Assignment)
    // Sesuaikan dengan foto phpMyAdmin kamu tadi
    protected $fillable = [
    'user_id', // Pastikan kolom ini ada dan 'reseller' tidak ada
    'tanggal_pesan',
    'total_produk',
    'total_harga',
    'alamat_pengiriman',
    'no_telepon_pengiriman',
    'status',
    'payment_status',
    'payment_url',
    'keterangan', // Tambahkan ini karena ada di migrasi
];

public function user()
{

    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}