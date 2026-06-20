<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support5\Facades\Hash;
use Illuminate\Support5\Facades\DB;
use Illuminate\Support5\Str;

class ForgotPasswordController extends Controller
{
    // 1. Menampilkan Halaman "Lupa Kata Sandi?"
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Mengirim Link Reset Token ke Email (Mailtrap)
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Buat token acak untuk pengaman link reset
        $token = Str::random(60);

        // Simpan token ke tabel internal bawaan laravel 'password_reset_tokens'
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetLink = url("/reset-password/{$token}?email={$request->email}");

        // [OPSIONAL] Kirim link ke Mailtrap
        // Mail::raw("Klik link berikut untuk mereset kata sandi Anda: $resetLink", function ($message) use ($request) {
        //     $message->to($request->email)->subject('Reset Kata Sandi Akun Brasil');
        // });

        return back()->with('success', 'Kami telah mengirimkan link reset kata sandi ke email kamu!');
    }

    // 3. Menampilkan Halaman Form Ketik Password Baru
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // 4. Update Password Lama Menjadi yang Baru di Database
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed|\Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->symbols()',
        ]);

        // Cek kevalidan token
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->with('failed', 'Token reset kata sandi tidak valid atau sudah kedaluwarsa.');
        }

        // Update password user asli
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token yang sudah terpakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan login.');
    }
}