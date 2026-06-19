<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    // READ - Tampilkan semua produk dengan Fitur FILTER / PENCARIAN
    public function index(Request $request)
    {
        $query = Produk::query();

        // Fitur Filter/Pencarian berdasarkan nama produk atau SKU
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Pagination 5 data per halaman dengan mempertahankan query string filter saat pindah halaman
        $produk = $query->paginate(5)->withQueryString();

        // API Response
        if ($request->is('api/*')) {
            return response()->json($produk);
        }

        // Web Response
        return view('produk.index', compact('produk'));
    }

    // CREATE - Tampilkan form tambah produk
    public function create()
    {
        return view('produk.create');
    }

    // CREATE - Simpan produk baru (FITUR TAMBAH)
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

        // API Response
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ]);
        }

        // Web Response
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE - Tampilkan form edit
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    // UPDATE - Simpan perubahan (FITUR UBAH)
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
            // Hapus foto lama jika ada di storage
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        // API Response
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ]);
        }

        // Web Response
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    // DELETE - Hapus produk (FITUR HAPUS)
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        // API Response
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);
        }

        // Web Response
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    // FITUR DOWNLOAD DATA (Mengunduh semua produk menjadi file CSV)
    public function downloadCsv()
    {
        $produk_all = Produk::all();
        $csvFileName = 'data-produk-' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nama Produk', 'SKU', 'Harga', 'Stok', 'Deskripsi'];

        $callback = function() use($produk_all, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($produk_all as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->nama_produk,
                    $item->sku,
                    $item->harga,
                    $item->stok,
                    $item->deskripsi,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // PUBLIC API
    public function externalApi()
    {
        // Memperbaiki sintaks Http:: menjadi Http::get
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return response()->json([
            'message' => 'Data dari Public API',
            'data' => $response->json()
        ]);
    }
}