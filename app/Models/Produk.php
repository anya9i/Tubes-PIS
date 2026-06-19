<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    
    protected $fillable = [
    'nama_produk',
    'sku',
    'harga',
    'stok',
    'foto',
    'deskripsi'
    ];
    // mematikan fitur timestamps otomatis
    public $timestamps = false;
}
