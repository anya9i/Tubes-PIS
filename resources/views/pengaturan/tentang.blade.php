@extends('layouts.app')

@section('content')

<div class="tentang-container">

    {{-- BREADCRUMB --}}
    <h6 class="page-subtitle">Pengaturan - Tentang</h6>

    {{-- CARD UTAMA --}}
    <div class="tentang-card">

        {{-- PROFIL ROW --}}
        <div class="profil-row">
            <div class="profil-left">
                <img src="{{ asset('images/avatar.jpeg') }}" class="profil-avatar" alt="Avatar">
                <div class="profil-info">
                    <h5>Fakhri Pangeran Beji</h5>
                    <p>owner@gmail.com</p>
                </div>
            </div>
            <span class="profil-role">Owner</span>
        </div>

        {{-- DIVIDER --}}
        <hr class="tentang-divider">

        {{-- DESKRIPSI --}}
        <p class="tentang-desc">
            Website Manajemen Stok ini dirancang untuk membantu pengguna dalam mengelola data persediaan barang
            secara efisien dan terstruktur. Fitur yang tersedia mendukung proses pencatatan barang masuk dan keluar,
            pemantauan stok, serta pengelolaan data pendukung lainnya.
        </p>

        {{-- VERSI --}}
        <div class="tentang-versi">
            <p><strong>Versi saat ini : v1.0.1</strong></p>
            <p><strong>Terakhir Diperbarui : 12/12/2025</strong></p>
        </div>

    </div>

</div>

@endsection

@push('styles')
<style>

.tentang-container {
    width: 850px;
    margin: auto;
}

.page-subtitle {
    color: #7c7c7c;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 18px;
}

.tentang-card {
    background: white;
    padding: 24px 28px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px !important;
}

/* Profil Row */
.profil-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

.profil-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.profil-avatar {
    width: 54px;
    height: 54px;
    border-radius: 50% !important;
    object-fit: cover;
    border: 2px solid #eee;
}

.profil-info h5 {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 2px 0;
    color: #1a1a1a;
}

.profil-info p {
    font-size: 12px;
    color: #888;
    margin: 0;
}

.profil-role {
    font-size: 13px;
    color: #555;
    font-weight: 500;
}

/* Divider */
.tentang-divider {
    border: none;
    border-top: 1px solid #ebebeb;
    margin: 0 0 18px 0;
}

/* Deskripsi */
.tentang-desc {
    font-size: 13px;
    color: #444;
    line-height: 1.75;
    margin-bottom: 18px;
    text-align: justify;
}

/* Versi */
.tentang-versi p {
    font-size: 13px;
    color: #222;
    margin: 0 0 4px 0;
    font-weight: 600;
}

</style>
@endpush