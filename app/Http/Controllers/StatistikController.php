<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan; 
use App\Models\User; 

class StatistikController extends Controller
{
    public function index()
    {
        // Ambil data detail untuk tabel Distribusi Produk
        $distribusiProduk = Pesanan::join('users', 'pesanan.user_id', '=', 'users.id')
            ->select(
                'users.nama_lengkap as nama',
                'users.role as jenis_toko',
                'pesanan.created_at as tanggal_pesan',
                'users.alamat',
                'pesanan.total_produk', 
                'pesanan.id as id_pemesanan' 
            )
            ->get();

        // Melempar data ke file view yang ada di folder views/statistik.blade.php
        return view('statistik.index', compact('distribusiProduk'));
    }
}