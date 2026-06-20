<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Mengambil dari tabel users sesuai analisis Maria
use Illuminate\Support\Facades\Hash; // Import Hash untuk mengamankan password

class ResellerController extends Controller
{
    // Menampilkan halaman utama dengan pagination (10 data per halaman)
    public function index()
    {
        // PERBAIKAN: Menampilkan semua user yang rolenya 'reseller' agar admin/super admin tidak ikut ter-render di tabel
        $resellers = User::where('role', 'reseller')->paginate(10);
        return view('reseller.index', compact('resellers'));
    }

    // Menyimpan reseller baru
    public function store(Request $request)
    {
        // 1. VALIDASI: Mengamankan agar username/email tidak kembar dan nomor telepon terisi valid
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'jenis_toko'   => 'nullable|string',
            'wilayah'      => 'nullable|string|max:255',
            'alamat'       => 'nullable|string',
            'no_telepon'   => 'required|numeric',
        ]);

        // 2. EKSEKUSI DATA: Memasukkan data lengkap akun log-in ke database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password), // Mengamankan password asli inputan user dengan Hash
            'role'         => 'reseller',                     // KUNCI HAK AKSES: Mengunci role tetap 'reseller' demi keamanan dashboard
            'jenis_toko'   => $request->jenis_toko,           // Menampung 'Agen' atau 'Reseller' dari select option
            'wilayah'      => $request->wilayah,
            'alamat'       => $request->alamat,
            'no_telepon'   => $request->no_telepon,
            'status'       => 'Aktif',                        // Default awal aktif
        ]);

        // PERBAIKAN: Dialihkan menggunakan route index agar setelah submit user diarahkan kembali ke tabel utama, bukan mengendap di page kosong
        return redirect()->route('reseller.index')->with('success', 'Akun Kemitraan Reseller baru berhasil didaftarkan ke sistem Brasil!');
    }

    // Mengubah status via dropdown tabel
    public function updateStatus(Request $request, $id)
    {
        $reseller = User::findOrFail($id);
        $reseller->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status akun berhasil diperbarui!');
    }

    // Menghapus massal data yang dicentang
    public function destroyMassal(Request $request)
    {
        $ids = json_decode($request->ids);
        if ($ids) {
            User::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'Data reseller terpilih berhasil dihapus!');
    }
}