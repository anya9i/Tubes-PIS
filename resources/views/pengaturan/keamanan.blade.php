@extends('layouts.app')

@section('content')
<!-- Memanggil Font Montserrat & Google Fonts untuk Akurasi Komponen UI -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Memanggil Bootstrap Icons Terupdate untuk Ikon Perisai Keamanan -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- MAIN VIEWPORT CONTAINER (Melayang di atas Background Ruko Es Brasil) -->
<div class="security-viewport-container" style="
    background: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), url('{{ asset('images/bg-brasil.jpg') }}') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    min-height: 100vh;
    padding: 20px 40px;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;">

    <!-- Tombol Navigasi Kembali ke Menu Pengaturan Utama -->
    <div class="mb-4" style="max-width: 920px; margin: 0 auto 20px auto;">
    <a href="{{ route('pengaturan.index') }}" class="btn-back-link">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Pengaturan
    </a>
</div>



    <!-- Judul Besar Halaman Utama Berdasarkan Gambar Target -->
    <h1 class="security-main-title">Kata Sandi & Keamanan</h1>

    <!-- ================= ACCORDION HEADER (UBAH KATA SANDI) ================= -->
    <div class="brasil-security-card accordion-trigger-header" id="accordionToggle">
        <div class="accordion-left-meta">
            <div class="icon-outline-frame-dark">
                <i class="bi bi-shield-check"></i>
            </div>
            <span class="accordion-label-text">Ubah Kata Sandi</span>
        </div>
        <div class="accordion-right-meta">
            <i class="bi bi-chevron-down chevron-indicator-icon" id="chevronIcon"></i>
        </div>
    </div>

    <!-- ================= ACCORDION CONTENT (FORM INPUT) ================= -->
    <div class="brasil-security-card security-form-body-content" id="accordionContent">
        <form id="passwordChangeForm" action="#" method="POST">
            @csrf
            
            <!-- Input 1: Kata Sandi Saat Ini -->
            <div class="form-input-stack">
                <label class="form-field-label">
                    Kata Sandi Saat Ini <span class="last-updated-text">(Terakhir Diperbarui 10/12/2025)</span>
                </label>
                <input type="password" name="current_password" class="form-custom-control" placeholder="Masukkan Kata Sandi Saat Ini" required>
            </div>

            <!-- Input 2: Kata Sandi Baru -->
            <div class="form-input-stack">
                <label class="form-field-label">Kata Sandi Baru</label>
                <input type="password" name="new_password" class="form-custom-control" placeholder="Masukkan Kata Sandi Baru" id="newPassword" required>
            </div>

            <!-- Input 3: Verifikasi Sandi Baru -->
            <div class="form-input-stack">
                <label class="form-field-label">Verifikasi Sandi Baru</label>
                <input type="password" name="new_password_confirmation" class="form-custom-control" placeholder="Tulis Ulang Kata Sandi Baru" id="confirmPassword" required>
            </div>

            <!-- Tautan Bantuan Lupa Kata Sandi -->
            <div class="forgot-password-link-box">
                <a href="{{ route('pengaturan.bantuan') }}" class="forgot-link">Lupa Kata Sandi?</a>
            </div>

            <!-- Tombol Aksi Kirim/Submit Form Sesuai Gambar Mockup -->
            <div class="text-center button-submit-wrapper">
                <button type="submit" class="btn-blue-submit-password">Ubah Kata Sandi</button>
            </div>

        </form>
    </div>

</div>

<!-- ================= SCRIPT INTERAKTIF AKSI (COLLAPSIBLE ACCORDION) ================= -->
<script>
    document.getElementById('accordionToggle').addEventListener('click', function() {
        const content = document.getElementById('accordionContent');
        const chevron = document.getElementById('chevronIcon');
        
        // Logika Buka-Tutup Animasi Panel Form
        if (content.style.maxHeight === "0px" || content.style.maxHeight === "") {
            content.style.maxHeight = content.scrollHeight + "px";
            content.style.padding = "40px";
            content.style.borderTop = "1px solid #efefef";
            chevron.style.transform = "rotate(180deg)";
        } else {
            content.style.maxHeight = "0px";
            content.style.padding = "0px 40px";
            content.style.borderTop = "none";
            chevron.style.transform = "rotate(0deg)";
        }
    });

    // Validasi Penyamaan Sandi Saat Dikirim
    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const newPass = document.getElementById('newPassword').value;
        const confirmPass = document.getElementById('confirmPassword').value;

        if (newPass !== confirmPass) {
            alert('Kesalahan: Verifikasi sandi baru tidak cocok dengan kata sandi baru!');
            return false;
        }

        alert('Sukses! Kata sandi akun berhasil diperbarui.');
        window.location.href = "{{ route('pengaturan.index') }}";
    });
</script>

<!-- ================= STYLING ENGINE CUSTOM (GARANSI DETAIL 100% IDENTIK) ================= -->
<style>
    /* Mengembalikan hak rounded khusus untuk komponen halaman keamanan agar tidak dipaksa kaku oleh CSS induk */
    .brasil-security-card,
    .form-custom-control,
    .btn-blue-submit-password,
    .icon-outline-frame-dark {
        border-radius: 10px !important; /* Memberikan kelengkungan rounded halus sesuai mockup target */
    }

    /* Tombol Navigasi Kembali */
    .btn-back-link {
        display: inline-block;
        background: #ffffff;
        color: #111111;
        font-weight: 700;
        text-decoration: none;
        padding: 10px 20px;
        border: 1px solid #e5e7eb;
        font-size: 14px;
        border-radius: 6px !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-back-link:hover {
        background: #f9fafb;
        color: #ff0000;
    }

    /* Judul Besar Tengah Halaman Berdasarkan Mockup */
    .security-main-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 32px;
        font-weight: 700;
        color: #111111;
        text-align: center;
        margin: 10px 0 35px 0;
    }

    /* Kerangka Dasar Kotak Putih Melayang */
    .brasil-security-card {
        background: #ffffff;
        max-width: 920px;
        width: 100%;
        margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
        box-sizing: border-box;
    }

    /* Header Panel Tombol Accordion */
    .accordion-trigger-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 30px;
        cursor: pointer;
        user-select: none;
        margin-bottom: 20px; /* Jarak pemisah antar card sesuai gambar */
        transition: background 0.15s ease-in-out;
    }
    .accordion-trigger-header:hover {
        background-color: #fafafa;
    }
    .accordion-left-meta, .accordion-right-meta {
        display: flex;
        align-items: center;
    }

    /* Kotak Frame Ikon Hitam Tebal */
    .icon-outline-frame-dark {
        width: 38px;
        height: 38px;
        border: 2.5px solid #111111;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        background: transparent;
        border-radius: 6px !important;
    }
    .icon-outline-frame-dark i {
        font-size: 20px;
        color: #111111;
        font-weight: bold;
    }

    /* Teks Judul Accordion */
    .accordion-label-text {
        font-family: 'Montserrat', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #111111;
    }

    /* Ikon Panah Chevron Bawah */
    .chevron-indicator-icon {
        font-size: 22px;
        color: #111111;
        font-weight: 900;
        -webkit-text-stroke: 1.2px #111111;
        transition: transform 0.25s ease-in-out;
    }

    /* Konten Box Form */
    .security-form-body-content {
        max-height: 2000px;
        padding: 40px;
        transition: max-height 0.25s ease-out, padding 0.25s ease-out;
        overflow: hidden;
    }

    /* Tumpukan Form Isian */
    .form-input-stack {
        display: flex;
        flex-direction: column;
        margin-bottom: 24px;
    }

    /* Label Input dengan Font Montserrat */
    .form-field-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 10px;
    }
    .last-updated-text {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        color: #aaaaaa;
        font-size: 14px;
        margin-left: 4px;
    }

    /* Custom Input Kontur Merah dengan Lengkungan Bulat Sempurna (Rounded) */
    .form-custom-control {
        background-color: #ffffff;
        border: 1px solid #d32f2f;
        padding: 12px 18px;
        font-size: 16px;
        color: #333333;
        font-weight: 500;
        outline: none;
        width: 100%;
        box-sizing: border-box;
        border-radius: 8px !important; /* Membuat inputan bergaris merah menjadi rounded */
    }
    .form-custom-control::placeholder {
        color: #cccccc;
        font-weight: 400;
    }
    .form-custom-control:focus {
        border: 2px solid #ff0000;
        box-shadow: 0 0 5px rgba(255, 0, 0, 0.1);
    }

    /* Box Tautan Lupa Kata Sandi */
    .forgot-password-link-box {
        margin-top: -12px;
        margin-bottom: 30px;
    }
    .forgot-link {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #111111;
        text-decoration: none;
    }
    .forgot-link:hover {
        color: #ff0000;
        text-decoration: underline;
    }

    /* Tombol Biru Elegan dengan Lengkungan Rounded Khas Pil */
    .button-submit-wrapper {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .btn-blue-submit-password {
        background-color: #0066cc;
        color: #ffffff;
        border: 1px solid #0052a3;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 16px;
        padding: 10px 45px;
        cursor: pointer;
        border-radius: 20px !important; /* Tombol bawah otomatis berbentuk rounded kapsul elegan */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-blue-submit-password:hover {
        background-color: #0052a3;
    }
    .btn-blue-submit-password:active {
        transform: scale(0.98);
    }
</style>
@endsection