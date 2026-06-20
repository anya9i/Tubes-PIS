<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan memanggil model User
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Fungsi untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('login.login'); 
    }

    // Fungsi untuk memproses login
    public function login(Request $request)
    {
        // 1. Validasi format input dari form
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah Email-nya ada di database atau tidak
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika email tidak terdaftar
            return back()->withErrors([
                'email' => 'Email yang kamu masukkan tidak terdaftar.',
            ])->withInput();
        }

        // 3. Jika email ada, cek apakah password-nya cocok atau salah
        if (!Hash::check($request->password, $user->password)) {
            // Jika password salah
            return back()->withErrors([
                'password' => 'Kata sandi yang kamu masukkan salah.',
            ])->withInput();
        }

        // 4. Jika semua benar, lakukan proses login resmi
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan sistem, silakan coba lagi.',
        ]);
    }

    // FUNGSI KELUAR (LOGOUT)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}