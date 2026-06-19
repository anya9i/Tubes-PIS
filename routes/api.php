<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PesananController; // Pastikan ini diimpor

// Route untuk Produk
Route::get('/produk', [ProductController::class, 'index']);
Route::post('/produk', [ProductController::class, 'store']);
Route::put('/produk/{id}', [ProductController::class, 'update']);
Route::delete('/produk/{id}', [ProductController::class, 'destroy']);
Route::get('/external', [ProductController::class, 'externalApi']);
// Hapus atau komen dulu route lain yang belum ada controllernya
Route::post('/midtrans-callback', [PesananController::class, 'callback']);