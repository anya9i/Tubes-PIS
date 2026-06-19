<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StatistikController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= Halaman Login ===================

// 1. Halaman Awal (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute untuk MENAMPILKAN halaman (GET)
Route::get('/login', function () {
    return view('login.login');
})->name('login'); // name() hanya berisi string nama rute

// 3. Rute untuk MEMPROSES data (POST)
Route::post('/login', [logincontroller::class, 'login']);

// 4. Halaman DASHBOARD (Setelah Login Berhasil)
Route::get('/dashboard', [Dashboardcontroller::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// ================= Registrasi ===================

Route::get('/register', function () {
    return view('auth.register'); // Pastikan filenya nanti dibuat ya
})->name('register');

//

Route::redirect('/', '/dashboard');

// ================= PRODUK =================

Route::resource('produk', ProductController::class);
// READ
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');

// CREATE
Route::get('/produk/create', [ProductController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProductController::class, 'store'])->name('produk.store');

// UPDATE
Route::get('/produk/{id}/edit', [ProductController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProductController::class, 'update'])->name('produk.update');

// DELETE
Route::delete('/produk/{id}', [ProductController::class, 'destroy'])->name('produk.destroy');


// ================= STOK =================

Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/stok/perbarui', [StokController::class, 'perbaruiForm'])->name('stok.edit');
Route::post('/stok/perbarui', [StokController::class, 'perbaruiUpdate'])->name('stok.update');


// ================= RESELLER =================

Route::get('/reseller', [ResellerController::class, 'index'])->name('reseller.index');
Route::get('/reseller/create', [ResellerController::class, 'create'])->name('reseller.create');
Route::post('/reseller', [ResellerController::class, 'store'])->name('reseller.store');
Route::post('/reseller/store', [ResellerController::class, 'store'])->name('reseller.store');
Route::post('/reseller/{id}/update-status', [ResellerController::class, 'updateStatus'])->name('reseller.updateStatus');
Route::post('/reseller/destroy-massal', [ResellerController::class, 'destroyMassal'])->name('reseller.destroyMassal');

Route::patch('/reseller/{id}/toggle-status', [ResellerController::class, 'toggleStatus'])
    ->name('reseller.toggleStatus');

Route::delete('/reseller/{id}', [ResellerController::class, 'destroy'])
    ->name('reseller.destroy');

Route::patch('/reseller/{id}/update-status', [ResellerController::class, 'updateStatus'])->name('reseller.updateStatus');


// ================= PESANAN =================

// Rute untuk menampilkan form tambah pesanan
Route::get('/pesanan/create', [App\Http\Controllers\PesananController::class, 'create'])->name('pesanan.create');

// Rute untuk menyimpan data pesanan baru
Route::post('/pesanan', [App\Http\Controllers\PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
Route::get('/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');

// ================= DASHBOARD =================

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index');

Route::get('/faq', function () {
    return view('faq.index');
})->name('faq.index');


// ================= PENGATURAN =================

Route::get('/pengaturan', function () {
    return view('pengaturan.index');
})->name('pengaturan.index');

Route::get('/pengaturan/keamanan', function () {
    return view('pengaturan.keamanan');
})->name('pengaturan.keamanan');

Route::get('/pengaturan/bahasa', function () {
    return view('pengaturan.bahasa');
})->name('pengaturan.bahasa');

Route::get('/pengaturan/tentang', function () {
    return view('pengaturan.tentang');
})->name('pengaturan.tentang');

Route::get('/pengaturan/profil', function () {
    return view('pengaturan.profil');
})->name('profil.index');

Route::get('/pengaturan/profil/edit', function () {
    return view('pengaturan.profil-edit');
})->name('profil.edit');

// ================= PAYMENT =================
Route::get('/pesanan/{id}/pay', [App\Http\Controllers\PesananController::class, 'pay'])->name('pesanan.pay');
Route::get('/pesanan/{id}/cancel-confirm', [PesananController::class, 'cancelConfirm'])->name('pesanan.cancel.confirm');

// ================= STATISTIK =================
Route::get('/statistik', [StatistikController::class, 'index']);




