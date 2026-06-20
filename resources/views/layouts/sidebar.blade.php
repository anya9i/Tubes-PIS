<div class="flex flex-col h-screen bg-white shadow-sm border-r border-gray-100 overflow-hidden">
    
    {{-- 1. BAGIAN LOGO (Dibuat mepet ke atas) --}}
    <div class="pt-4 pb-2 flex justify-center flex-shrink-0">
        <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" style="max-width:110px;">
    </div>

    {{-- 2. BAGIAN TENGAH (Menu Utama dengan Background Abu-abu Tipis) --}}
    <div class="flex-grow overflow-y-auto px-3 custom-scrollbar">
        {{-- Kotak Background di belakang menu --}}
        <div class="bg-gray-50 rounded-2xl p-2 mt-2 shadow-inner border border-gray-100">
            <nav class="space-y-1">
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-bold">Dashboard</span>
                </a>

                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="font-bold">Produk</span>
                </a>

                <a href="/pesanan" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('pesanan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span class="font-bold">Pesanan</span>
                </a>

                <a href="/stok" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('stok*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span class="font-bold">Stok</span>
                </a>

                {{-- KUNCI UTAMA: Menu Reseller & Statistik dibungkus agar HANYA muncul untuk admin dan super admin --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super admin')
                    <a href="/reseller" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('reseller*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group"></i>
                        <span class="font-bold">Reseller</span>
                    </a>

                    <a href="/statistik" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('statistik*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="font-bold">Statistik</span>
                    </a>
                @endif
            </nav>
        </div>
    </div>

    {{-- 3. BAGIAN BAWAH (Menu Sistem & Keluar) --}}
    <div class="p-3 mb-4 flex-shrink-0 border-t border-gray-100">
        <nav class="space-y-1">
            <a href="/pengaturan" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link {{ request()->is('pengaturan*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                <span class="font-bold">Pengaturan</span>
            </a>

            <a href="/logout" class="flex items-center gap-3 px-4 py-3 no-underline sidebar-link text-gray-800 hover:bg-red-50 hover:text-red-600 transition-all">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="font-bold">Keluar</span>
            </a>
        </nav>
    </div>
</div>

<style>
    /* Styling Link */
    .sidebar-link {
        color: #1f2937; /* Abu-abu gelap/hitam */
        border-radius: 200px;
        transition: all 0.3s ease;
        font-size: 13px; /* Kotak lebih kecil, font sedikit dikecilkan */
    }

    /* Menu Aktif: Merah Brasil */
    .sidebar-link.active {
        background-color: #ff0000 !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(255, 0, 0, 0.3);
    }

    .sidebar-link:hover:not(.active) {
        background-color: rgba(255, 0, 0, 0.05);
        color: #ff0000;
    }

    /* Menghilangkan scrollbar agar estetik */
    .custom-scrollbar::-webkit-scrollbar { width: 0px; background: transparent; }
</style>