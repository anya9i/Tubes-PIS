<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// KUNCI UTAMA: Wajib import Auth facade agar tidak eror saat memanggil Auth::user()
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function index()
    {
        // Ini yang akan memanggil file resources/views/dashboard/index.blade.php
        return view('dashboard.index');
    }

    // PERBAIKAN: Fungsi showProfil sekarang sudah masuk ke dalam lingkup class DashboardController
    public function showProfil()
    {
        // Memanggil file resources/views/pengaturan/infoprofil.blade.php kamu
        return view('pengaturan.infoprofil'); 
    }

    // PERBAIKAN: Fungsi updateProfil sekarang berada di dalam lingkup class DashboardController
    public function updateProfil(Request $request)
    {
        // Mengambil objek user yang sedang login saat ini
        $user = Auth::user();

        // Validasi dasar kiriman data
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Mengisi data modifikasi dasar
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username     = $request->username;
        $user->email        = $request->email;

        // Tambahan isian spesifik jika peran akun adalah reseller
        if ($user->role === 'reseller') {
            $user->no_telepon = $request->no_telepon;
            $user->wilayah    = $request->wilayah;
            $user->alamat     = $request->alamat;
        }

        // Eksekusi simpan ke tabel database
        $user->save();

        // Kembalikan ke halaman profil dengan pesan sukses
        return redirect()->back()->with('success', 'Data perubahan profil berhasil disimpan ke sistem toko Brasil.');
    }
} 