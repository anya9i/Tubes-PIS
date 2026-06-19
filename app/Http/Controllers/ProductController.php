<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Daftar Stok
    public function index()
    {
        $produk = Produk::all();
        return view('stok.index', compact('produk'));
    }

    // Tampilkan form perbarui stok umum
    public function perbaruiForm()
    {
        $produks = Produk::all();
        return view('stok.edit', compact('produks'));
    }

    // Simpan update stok
    public function perbaruiUpdate(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah_stok' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $produk->stok = $request->jumlah_stok;
        $produk->save();

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui!');
    }
}