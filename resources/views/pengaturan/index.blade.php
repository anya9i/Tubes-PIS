@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="setting-viewport-container" style="
    background: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), url('{{ asset('images/bg-brasil.jpg') }}') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    min-height: 100vh;
    padding: 40px;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;">

    <div class="brasil-card profile-main-card">
        <div class="profile-meta-left">
            <img src="{{ asset('images/avatar.jpeg') }}" class="avatar-img-fluid" alt="Foto Profil Admin">
            <div class="identity-text-stack">
                <!-- Diubah menjadi teks manual/statis -->
                <h2 class="user-name-title">Admin Es & Kopi Brasil</h2>
                <p class="user-email-subtitle">admin@gmail.com</p>
            </div>
        </div>
        <div class="profile-meta-right">
            <!-- Diubah menjadi teks manual/statis -->
            <span class="user-role-text">Admin</span>
        </div>
    </div>
    <h3 class="section-badge-title">Profil</h3>

    <div class="brasil-card single-clickable-row-box">
        <a href="{{ route('pengaturan.profil') }}" class="menu-action-trigger">
            <div class="menu-action-left">
                <div class="icon-square-frame">
                    <i class="bi bi-person-square"></i>
                </div>
                <span class="menu-action-label">Info Profil</span>
            </div>
            <div class="menu-action-right">
                <i class="bi bi-chevron-right chevron-bold-dark"></i>
            </div>
        </a>
    </div>

    <h3 class="section-badge-title">Pengaturan Akun</h3>

    <div class="brasil-card group-list-card-box">
        
        <a href="{{ route('pengaturan.keamanan') }}" class="menu-action-trigger item-border-bottom">
            <div class="menu-action-left">
                <div class="icon-square-frame">
                    <i class="bi bi-shield-check"></i>
                </div>
                <span class="menu-action-label">Kata Sandi & Keamanan</span>
            </div>
            <div class="menu-action-right">
                <i class="bi bi-chevron-right chevron-bold-dark"></i>
            </div>
        </a>

        <a href="{{ route('pengaturan.bahasa') }}" class="menu-action-trigger item-border-bottom">
            <div class="menu-action-left">
                <div class="icon-square-frame">
                    <i class="bi bi-globe2"></i>
                </div>
                <span class="menu-action-label">Bahasa</span>
            </div>
            <div class="menu-action-right">
                <span class="lang-status-pill">Indonesia</span>
                <i class="bi bi-chevron-right chevron-bold-dark"></i>
            </div>
        </a>

        <a href="{{ route('pengaturan.bantuan') }}" class="menu-action-trigger item-border-bottom">
            <div class="menu-action-left">
                <div class="icon-square-frame">
                    <i class="bi bi-headset"></i>
                </div>
                <span class="menu-action-label">Bantuan</span>
            </div>
            <div class="menu-action-right">
                <i class="bi bi-chevron-right chevron-bold-dark"></i>
            </div>
        </a>

        <a href="{{ route('pengaturan.tentang') }}" class="menu-action-trigger">
            <div class="menu-action-left">
                <div class="icon-square-frame">
                    <i class="bi bi-info-square"></i>
                </div>
                <span class="menu-action-label">Tentang</span>
            </div>
            <div class="menu-action-right">
                <i class="bi bi-chevron-right chevron-bold-dark"></i>
            </div>
        </a>

    </div>

</div>

<style>
    /* Dasar Kartu Putih Melayang */
    .brasil-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        margin: 0 auto 24px auto;
        max-width: 920px;
        width: 100%;
        overflow: hidden;
        border: none;
    }

    /* Spesifik Struktur Profil Atas */
    .profile-main-card {
        padding: 24px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-sizing: border-box;
    }
    .profile-meta-left {
        display: flex;
        align-items: center;
    }
    .avatar-img-fluid {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 24px;
    }
    .identity-text-stack .user-name-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #111111;
        margin: 0 0 4px 0;
    }
    .identity-text-stack .user-email-subtitle {
        font-size: 17px;
        color: #6c757d;
        margin: 0;
    }
    .user-role-text {
        font-size: 18px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Judul Seksi Tengah */
    .section-badge-title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        color: #111111;
        margin: 30px 0 16px 0;
    }

    /* Baris Link Pemicu Aksi Utama */
    .menu-action-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 30px;
        text-decoration: none;
        box-sizing: border-box;
        transition: all 0.2s ease-in-out; /* Animasi transisi smooth */
    }
    
    .menu-action-left, .menu-action-right {
        display: flex;
        align-items: center;
    }

    /* Frame Kotak Ikon Kontur Hitam */
    .icon-square-frame {
        width: 40px;
        height: 40px;
        border: 2.5px solid #111111;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        background: transparent;
        transition: all 0.2s ease-in-out;
    }
    .icon-square-frame i {
        font-size: 22px;
        color: #111111;
        font-weight: bold;
        transition: all 0.2s ease-in-out;
    }
    .menu-action-label {
        font-size: 19px;
        font-weight: 500;
        color: #111111;
        transition: all 0.2s ease-in-out;
    }

    /* Garis Pembatas Dalam Grup */
    .item-border-bottom {
        border-bottom: 1.5px solid #efefef;
    }

    /* Tanda Panah Kanan Tebal */
    .chevron-bold-dark {
        font-size: 24px;
        color: #111111;
        font-weight: 800;
        -webkit-text-stroke: 1px #111111;
        transition: all 0.2s ease-in-out;
    }

    /* Status Bahasa Kontur */
    .lang-status-pill {
        border: 1px solid #cccccc;
        color: #999999;
        padding: 5px 18px;
        border-radius: 6px;
        font-size: 16px;
        margin-right: 14px;
        background: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    /* ================= EFFECT HOVER MERAH (ZERO MISTAKE MECHANISM) ================= */
    .menu-action-trigger:hover {
        background-color: #ff0000 !important; /* Latar belakang baris menjadi merah */
    }

    /* Mengubah warna teks komponen di dalam baris saat dihover */
    .menu-action-trigger:hover .menu-action-label {
        color: #ffffff !important;
    }

    /* Mengubah kotak frame ikon menjadi putih saat dihover */
    .menu-action-trigger:hover .icon-square-frame {
        border-color: #ffffff !important;
    }
    .menu-action-trigger:hover .icon-square-frame i {
        color: #ffffff !important;
    }

    /* Mengubah tanda panah kanan menjadi putih saat dihover */
    .menu-action-trigger:hover .chevron-bold-dark {
        color: #ffffff !important;
        -webkit-text-stroke: 1px #ffffff;
    }

    /* Mengubah pill text bahasa menjadi senada saat dihover */
    .menu-action-trigger:hover .lang-status-pill {
        background-color: rgba(255, 255, 255, 0.2) !important;
        border-color: #ffffff !important;
        color: #ffffff !important;
    }
</style>
@endsection