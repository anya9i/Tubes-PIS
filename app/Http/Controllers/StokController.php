<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Tampilkan Halaman Daftar Stok (Pakai Foto)
    public function index()
    {
        $produk = Produk::paginate(5);
        return view('stok.index', compact('produk'));
    }

    // Update Cepat Jumlah Stok dari Halaman Stok
    public function updateCepat(Request $request)
    {
        $request->validate([
            'produk_id'   => 'required|exists:produk,id',
            'jumlah_stok' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $produk->stok = $request->jumlah_stok;
        $produk->save();

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui!');
    }

    // Tambah Varian Produk Baru dari Modal
    public function store(Request $request)
    {
        // 1. Validasi input dari modal tambah stok
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'sku'         => 'required|string|unique:produk,sku', // memastikan SKU tidak kembar
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        // 2. Simpan ke database menggunakan Model Produk (Lebih ringkas karena sudah di-import di atas)
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'sku'         => $request->sku,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
        ]);

        // 3. Kembalikan ke halaman stok dengan pesan sukses
        return redirect()->route('stok.index')->with('success', 'Varian stok produk baru berhasil ditambahkan!');
    }

    /**
     * FIX: Mengubah ketersediaan stok produk menjadi 0 (Kosong) saat tombol hapus diklik
     * Rute: DELETE /stok/{id}/delete
     */
    public function destroy($id)
    {
        // 1. Cari data produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // 2. Eksekusi Perubahan: Ubah nilai kolom stok menjadi 0
        $produk->update([
            'stok' => 0
        ]);

        // 3. Kembali ke halaman indeks stok dengan membawa notifikasi sukses
        return redirect()->route('stok.index')->with('success', 'Stok untuk produk ' . $produk->nama_produk . ' berhasil dikosongkan menjadi 0!');
    }
}