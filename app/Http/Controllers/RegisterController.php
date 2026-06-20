<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    // 1. Menampilkan Halaman Form Registrasi
    public function showRegisterForm()
    {
        return view('auth.register'); // Sesuaikan dengan nama file register.blade kamu
    }

    // 2. Memproses Data Pendaftaran & Memicu OTP
    public function register(Request $request)
    {
        // Validasi input form secara ketat sesuai request kamu
        $request->validate([
            'email'      => 'required|string|email|max:255|unique:users',
            'first_name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
            'last_name'  => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
            'password'   => [
                'required', 
                'string', 
                'confirmed', 
                \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->symbols()
            ],
        ]);

        // Acak 5 Digit Angka OTP (untuk 5 kotak di UI Continue)
        $otpCode = rand(10000, 99999);

        // Simpan data user ke database (Akun dikunci dulu lewat is_active = false)
        // 3. Simpan data user ke database
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            // KUNCI PERBAIKAN: Ubah 'name' menjadi 'nama_lengkap' sesuai kolom di database
            'nama_lengkap' => $request->first_name . ' ' . $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            
            // KUNCI PERBAIKAN: Masukkan kolom username di sini!
            // Kita buat username otomatis dari email (sebelum tanda @)
            'username'   => explode('@', $request->email)[0], 
            
            'otp_code'   => $otpCode, 
            'is_active'  => false, 
        ]);
        // Simpan email ke session agar UI OTP bisa menampilkan teks email target
        session(['email_for_otp' => $request->email]);

        // [OPSIONAL] Kirim Email OTP ke Mailtrap
        // Mail::raw("Kode OTP Registrasi Brasil Anda adalah: $otpCode", function ($message) use ($user) {
        //     $message->to($user->email)->subject('Kode Verifikasi OTP Akun Brasil');
        // });

        // Belokkan alur masuk ke halaman pengisian kode OTP
        return redirect()->route('otp.view')->with('success', 'Registrasi berhasil! Silakan periksa kode OTP.');
    }

    // 3. Menampilkan Halaman 5 Kotak Input OTP
    public function showOtpForm()
    {
        // Proteksi: Jika tidak ada session email, tendang balik ke register
        if (!session('email_for_otp')) {
            return redirect()->route('register')->with('failed', 'Silakan registrasi terlebih dahulu.');
        }
        return view('auth.otp');
    }

    // 4. Memverifikasi 5 Digit Angka yang Diketik User
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:5', // Validasi array harus pas 5 kotak
        ]);

        // Menggabungkan array array [1, 2, 3, 4, 5] menjadi string tunggal "12345"
        $insertedOtp = implode('', $request->otp);
        $email = session('email_for_otp');

        // Cari user berdasarkan email dan kode OTP-nya
        $user = User::where('email', $email)->where('otp_code', $insertedOtp)->first();

        if (!$user) {
            return back()->with('failed', 'Kode OTP yang kamu masukkan salah! Periksa kembali.');
        }

        // Jika cocok, aktifkan akun dan hapus kode OTP agar tidak bisa dipakai lagi
        $user->is_active = true;
        $user->otp_code = null;
        $user->save();

        // Hapus session temporary email
        session()->forget('email_for_otp');

        // Sukses! Lempar ke halaman login utama
        return redirect()->route('login')->with('success', 'Akun kamu berhasil diverifikasi! Silakan login.');
    }
    
}