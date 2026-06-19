<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateStok extends Model
{
    protected $table = 'update_stok';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'jumlah_baru',
        'keterangan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
