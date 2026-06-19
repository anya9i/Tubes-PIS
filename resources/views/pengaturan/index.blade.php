@extends('layouts.app')

@section('content')

<div class="setting-container">

    <h6 class="page-title">Pengaturan</h6>

    {{-- PROFILE CARD --}}
    <div class="profile-card">

        <div class="profile-left">
            <img src="{{ asset('images/avatar.jpeg') }}" class="avatar">

            <div>
                <h5>Fakhri Pangeran Beji</h5>
                <p>owner@gmail.com</p>
            </div>
        </div>

        <span class="role">Owner</span>

    </div>

    {{-- PROFIL --}}
    <h2 class="section-title">Profil</h2>

    <div class="menu-card">

        <a href="{{ url('/pengaturan/info-profil') }}" class="menu-item">
            <div>
                <i class="fa-regular fa-user"></i>
                Info Profil
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

    </div>

    {{-- PENGATURAN AKUN --}}
    <h2 class="section-title">Pengaturan Akun</h2>

    <div class="menu-card">

        <a href="{{ url('/pengaturan/keamanan') }}" class="menu-item">
            <div>
                <i class="fa-solid fa-shield-halved"></i>
                Kata Sandi & Keamanan
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a href="#" class="menu-item">
            <div>
                <i class="fa-solid fa-globe"></i>
                Bahasa
            </div>

            <div>
                <span class="language">Indonesia</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </a>

        <a href="#" class="menu-item">
            <div>
                <i class="fa-solid fa-headset"></i>
                Bantuan
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a href="{{ url('/pengaturan/tentang') }}" class="menu-item">
            <div>
                <i class="fa-regular fa-file-lines"></i>
                Tentang
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

    </div>

</div>

@endsection

@push('styles')

<style>

.setting-container{
    width:850px;
    margin:auto;
}

.page-title{
    color:#7c7c7c;
    margin-bottom:10px;
}

.profile-card{
    background:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-radius:8px !important;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.profile-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.avatar{
    width:60px;
    height:60px;
    border-radius:50% !important;
    object-fit:cover;
}

.profile-card h5{
    font-size:16px;
    margin:0;
    font-weight:700;
}

.profile-card p{
    margin:0;
    color:#777;
    font-size:13px;
}

.role{
    color:#666;
    font-size:14px;
}

.section-title{
    text-align:center;
    margin:20px 0 12px;
    font-weight:700;
    font-size:20px;
}

.menu-card{
    background:white;
    border-radius:8px !important;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.menu-item{
    position:relative;
    overflow:hidden;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:18px 22px;

    color:#222;
    text-decoration:none;

    border-bottom:1px solid #eee;

    transition:.3s;
    z-index:1;
}

.menu-item::before{
    content:'';
    position:absolute;
    top:0;
    left:0;

    width:0;
    height:100%;

    background:#ff0000;

    transition:.35s ease;
    z-index:-1;
}

.menu-item:hover::before,
.menu-item.active::before{
    width:100%;
}

.menu-item:hover,
.menu-item.active{
    color:white;
}

.menu-item:hover i,
.menu-item.active i{
    color:white;
}

.menu-item i:first-child{
    width:25px;
}

.language{
    border:1px solid #ddd;
    padding:4px 12px;
    margin-right:10px;
}

</style>

@endpush