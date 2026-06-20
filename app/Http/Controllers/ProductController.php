<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    // READ - Tampilkan semua produk dengan Fitur FILTER / PENCARIAN
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $produk = $query->paginate(5)->withQueryString();

        if ($request->is('api/*')) {
            return response()->json($produk);
        }

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

        // FIX: Upload langsung dialihkan ke folder public/images
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Membuat nama unik agar file tidak saling menimpa
            $nama_foto = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Pindahkan langsung ke root folder public/images proyek
            $file->move(public_path('images'), $nama_foto);
            
            // Simpan nama filenya saja ke database
            $data['foto'] = $nama_foto;
        }

        $produk = Produk::create($data);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ]);
        }

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

        // FIX: Upload dan hapus foto lama langsung di direktori public/images
        if ($request->hasFile('foto')) {
            // Hapus file fisik lama di folder public/images jika ada
            if ($produk->foto && file_exists(public_path('images/' . $produk->foto))) {
                unlink(public_path('images/' . $produk->foto));
            }
            
            $file = $request->file('foto');
            $nama_foto = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Pindahkan file baru
            $file->move(public_path('images'), $nama_foto);
            $data['foto'] = $nama_foto;
        }

        $produk->update($data);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    // DELETE - Hapus produk (FITUR HAPUS)
    // FIX: Menyuntikkan Request $request ke parameter agar tidak memicu error API response
    public function destroy(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus file fisik di folder public/images sebelum data database dihilangkan
        if ($produk->foto && file_exists(public_path('images/' . $produk->foto))) {
            unlink(public_path('images/' . $produk->foto));
        }

        $produk->delete();

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);
        }

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
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return response()->json([
            'message' => 'Data dari Public API',
            'data' => $response->json()
        ]);
    }
}