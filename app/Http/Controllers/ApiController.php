<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    // GET semua produk
    public function getProduk()
    {
        $produk = Produk::all();

        return response()->json([
            'status' => 'success',
            'data' => $produk
        ]);
    }

    // POST tambah produk
    public function storeProduk(Request $request)
    {
        $produk = Produk::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $produk
        ]);
    }

    // UPDATE produk
    public function updateProduk(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diupdate',
            'data' => $produk
        ]);
    }

    // DELETE produk
    public function deleteProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    // PUBLIC API 
    public function externalApi()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return response()->json([
            'status' => 'success',
            'message' => 'Data dari Public API',
            'data' => $response->json()
        ]);
    }
}