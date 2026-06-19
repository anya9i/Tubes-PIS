<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Mengambil dari tabel users sesuai analisis Maria

class ResellerController extends Controller
{
    // Menampilkan halaman utama dengan pagination (10 data per halaman)
    public function index()
    {
        // Mengambil users yang rolenya reseller, agen, atau outlet
        $resellers = User::whereIn('role', ['reseller', 'agen', 'outlet'])->paginate(10);
        return view('reseller.index', compact('resellers'));
    }

    // Menyimpan reseller baru
    public function store(Request $request)
    {
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
            'wilayah' => $request->wilayah,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'status' => 'Aktif', // Default awal aktif
            'password' => bcrypt('12345678') // Default password akun baru
        ]);

        return redirect()->back()->with('success', 'Reseller baru berhasil ditambahkan!');
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