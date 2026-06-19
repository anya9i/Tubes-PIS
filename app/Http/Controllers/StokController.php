<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class StokController extends Controller
{
    // READ - Tampilkan semua produk
    public function index()
    {
        // SINKRONISASI: Ubah nama variabel menjadi $produk (tanpa 's') sesuai request di file View
        $produk = Produk::paginate(5);

        // API
        if (request()->is('api/*')) {
            return response()->json($produk);
        }

        // PERBAIKAN: Arahkan ke folder 'stok.index' bukan 'produk.index'
        return view('stok.index', compact('produk'));
    }

    // CREATE - Tampilkan form tambah produk
    public function create()
    {
        return view('stok.create');
    }

    // CREATE - Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'sku'         => 'required|string|max:50|unique:produk,sku',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'   => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        // API
        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ]);
        }

        // Web - Sesuaikan rute redirect
        return redirect()->route('stok.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE - Tampilkan form edit
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('stok.edit', compact('produk'));
    }

    // UPDATE - Simpan perubahan
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'sku'         => 'required|string|max:50|unique:produk,sku,' . $id,
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'   => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        // API
        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Produk berhasil diupdate!');
    }

    // DELETE - Hapus produk (Digunakan oleh tombol hapus interaktif kita)
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        // API
        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Produk berhasil dihapus!');
    }

    // PUBLIC API
    public function externalApi()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return response()->json([
            'message' => 'Data dari Public API',
            'data' => $response->json()
        ]);
    }
}