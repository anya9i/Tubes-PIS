<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= HALAMAN AWAL (REDIRECT) =================
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= AUTENTIKASI (LOGIN & LOGOUT) =================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout']);

// --- RUTE REGISTRASI & OTP ---
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('otp.view');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

// --- RUTE LUPA KATA SANDI ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


// ================= GRUP RUTE TERKUNCI (WAJIB LOGIN) =================
Route::middleware(['auth'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ================= PRODUK =================
    Route::get('/produk/download', [ProductController::class, 'downloadCsv'])->name('produk.download');
    Route::resource('produk', ProductController::class);

    // ================= STOK =================
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::post('/stok/update-cepat', [StokController::class, 'updateCepat'])->name('stok.update_cepat');
    Route::get('/stok/perbarui', [StokController::class, 'perbaruiForm'])->name('stok.edit');
    Route::post('/stok/perbarui', [StokController::class, 'perbaruiUpdate'])->name('stok.update');
    Route::post('/stok/store', [StokController::class, 'store'])->name('stok.store');
    Route::delete('/stok/{id}/delete', [StokController::class, 'destroy'])->name('stok.delete');

    // ================= PESANAN & PAYMENT =================
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::get('/pesanan/{id}/pay', [PesananController::class, 'pay'])->name('pesanan.pay');
    Route::get('/pesanan/{id}/cancel-confirm', [PesananController::class, 'cancelConfirm'])->name('pesanan.cancel.confirm');

    // ================= PENGATURAN =================
    Route::get('/pengaturan', function () { return view('pengaturan.index'); })->name('pengaturan.index');
    Route::get('/pengaturan/profil', function () { return view('pengaturan.infoprofil'); })->name('pengaturan.profil');
    Route::get('/pengaturan/keamanan', function () { return view('pengaturan.keamanan'); })->name('pengaturan.keamanan');
    Route::get('/pengaturan/bahasa', function () { return view('pengaturan.bahasa'); })->name('pengaturan.bahasa');
    Route::get('/pengaturan/bantuan', function () { return view('pengaturan.bantuan'); })->name('pengaturan.bantuan');
    Route::get('/pengaturan/tentang', function () { return view('pengaturan.tentang'); })->name('pengaturan.tentang');


    // ================= PROTEKSI KHUSUS (HANYA ADMIN & SUPER ADMIN) =================
    // User normal (reseller/customer) akan langsung diblokir ke halaman 403 jika mengakses rute di bawah ini
    Route::middleware([function ($request, $next) {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        return $next($request);
    }])->group(function () {
        
        // --- STATISTIK ---
        Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

        // --- ALL RESELLER ROUTES ---
        Route::get('/reseller', [ResellerController::class, 'index'])->name('reseller.index');
        Route::get('/reseller/create', [ResellerController::class, 'create'])->name('reseller.create');
        Route::post('/reseller', [ResellerController::class, 'store'])->name('reseller.store');
        Route::post('/reseller/destroy-massal', [ResellerController::class, 'destroyMassal'])->name('reseller.destroyMassal');
        Route::patch('/reseller/{id}/toggle-status', [ResellerController::class, 'toggleStatus'])->name('reseller.toggleStatus');
        Route::post('/reseller/{id}/update-status', [ResellerController::class, 'updateStatus'])->name('reseller.updateStatus');
        Route::delete('/reseller/{id}', [ResellerController::class, 'destroy'])->name('reseller.destroy');
        
    });

});


// ================= UTILITY URL (HOSTING & STORAGE) =================
Route::get('/buat-storage-link', function () {
    $targetFolder = base_path() . '/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    if (!file_exists($linkFolder)) {
        symlink($targetFolder, $linkFolder);
        return 'Storage link berhasil dibuat! Silakan cek kembali gambar di dashboard.';
    }
    return 'Storage link sudah ada.';
});

Route::get('/clear-semua-cache', function() {
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return "Semua cache di hosting berhasil dihancurkan total!";
});