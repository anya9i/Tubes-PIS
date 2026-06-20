<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es & Kopi Brasil - Dashboard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Reset semua rounded menjadi rectangle sesuai mockup */
        * {
            border-radius: 0 !important;
        }

        body { 
            font-family: 'Montserrat', sans-serif; 
            margin: 0;
            padding: 0;
        }
        
        /* Background Styling */
        .app-bg {
            position: fixed;
            inset: 0;
            background-image: url('{{ asset('images/bg-toko.jpeg') }}');
            background-size: cover;
            background-position: center;
            z-index: -10;
        }

        .app-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(252, 248, 248, 0.49);
            backdrop-filter: blur(0.25px);
        }

        /* Sidebar Styling */
        .sidebar {
            width: 200px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #e5e7eb;
            z-index: 50;
            margin-left: 30px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 24px;
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar-item i {
            width: 20px;
            margin-right: 15px;
        }

        .sidebar-item.active {
            background-color: #ff0000;
            color: white !important;
            border-left: 4px solid #8B0000;
        }

        .sidebar-item:hover:not(.active) {
            background-color: #f9fafb;
            color: #ff0000;
        }

        /* Navbar/Header Styling */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 80px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        /* Input Pencarian Rectangle */
        .search-input {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 10px 15px 10px 40px;
            width: 100%;
            outline: none;
        }

        /* Nav Links Menu Kanan */
        .menu-right a {
            color: #111111;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            margin-left: 25px;
            letter-spacing: 0.5px;
        }

        .menu-right a:hover {
            color: #ff0000;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 230px;
            padding-top: 80px;
            min-height: 100vh;
            width: calc(100% - 230px);
        }

        .main-content.full-top {
            padding-top: 20px;
        }

        .content-wrapper {
            padding: 40px;
            max-width: 100%;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
    
    <div class="app-bg"></div>

    <div class="flex">
        <aside class="sidebar flex flex-col py-6 no-scrollbar">
            <div class="logo text-center mb-0">
                <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" class="mx-auto" style="width: 125px;">
            </div>

            <nav class="flex-1 mt-6">
                <a href="/dashboard" class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>
                <a href="/produk" class="sidebar-item {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i> <span>Produk</span>
                </a>
                <a href="/pesanan" class="sidebar-item {{ request()->is('pesanan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i> <span>Pesanan</span>
                </a>
                <a href="/stok" class="sidebar-item {{ request()->is('stok*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i> <span>Stok</span>
                </a>

                {{-- KUNCI BARIKADE SIDEBAR: Hanya admin & super admin yang bisa melihat Reseller & Statistik --}}
                @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'super admin'))
                    <a href="/reseller" class="sidebar-item {{ request()->is('reseller*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group"></i> <span>Reseller</span>
                    </a>
                    <a href="/statistik" class="sidebar-item {{ request()->is('statistik*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i> <span>Statistik</span>
                    </a>
                @endif
            </nav>

            <div class="mt-auto border-t border-gray-200 pt-4">
                <a href="/pengaturan" class="sidebar-item {{ request()->is('pengaturan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i> <span>Pengaturan</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" class="sidebar-item text-red-600" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Keluar</span>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            
            @if (!Route::is('pengaturan.*') && Request::path() !== 'pengaturan')
                <nav class="top-navbar">
                    <div class="flex-1 max-w-xl">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </span>
                            <input type="text" class="search-input" placeholder="Cari produk di sini">
                        </div>
                    </div>
                    
                    <div class="menu-right">
                        @php
                            $jam = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->hour;
                            
                            if ($jam >= 5 && $jam < 11) {
                                $salam = 'Selamat Pagi';
                            } elseif ($jam >= 11 && $jam < 15) {
                                $salam = 'Selamat Siang';
                            } elseif ($jam >= 15 && $jam < 18) {
                                $salam = 'Selamat Sore';
                            } else {
                                $salam = 'Selamat Malam';
                            }
                        @endphp

                        <a href="#" style="text-decoration: none; font-weight: 600;">
                            {{-- KUNCI DINAMIS NAVBAR: Mengubah ->name menjadi ->nama_lengkap --}}
                            {{ $salam }}, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                        </a>
                    </div>
                </nav>
            @endif

            <main class="main-content {{ (Route::is('pengaturan.*') || Request::path() === 'pengaturan') ? 'full-top' : '' }}">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>