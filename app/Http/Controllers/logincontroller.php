<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- 1. WAJIB TAMBAHKAN INI

class logincontroller extends Controller
{
    public function login(Request $request)
{
    // Validasi input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Proses autentikasi menggunakan EMAIL
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

}
