<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Stok extends Model
{
    use HasFactory;

    // Jika nama tabelmu di database bukan 'stoks', tentukan di sini
    protected $table = 'stok'; 

    // Masukkan kolom apa saja yang boleh diisi
    protected $fillable = ['nama_produk', 'jumlah', 'harga'];
}

