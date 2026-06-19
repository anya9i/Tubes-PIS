@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-sm p-4" style="border-radius: 15px; background: rgba(255,255,255,0.95);">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0" style="font-family: 'Montserrat', sans-serif;">Status Pesanan</h4>
        <div class="d-flex gap-2">
            @if($pesanans->count() > 0)
                <a href="{{ route('pesanan.edit', $pesanans[0]->id) }}" class="btn btn-edit-figma">Edit</a>
            @else
                <button class="btn btn-edit-figma" disabled>Edit</button>
            @endif

            <button class="btn btn-action-outline d-flex align-items-center">
                <div class="d-flex align-items-center me-2" style="gap: 2px;">
                    <i class="fa-solid fa-arrow-up" style="font-size: 11px; color: #707680;"></i>
                    <i class="fa-solid fa-arrow-down" style="font-size: 11px; color: #707680;"></i>
                </div>
                <span>Sort</span>
            </button>
            <button class="btn btn-action-outline">Download</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle border-0">
            <thead>
                <tr class="text-dark fw-bold" style="font-size: 14px;">
                    <th class="pb-3 px-2">ID Transaksi</th>
                    <th class="pb-3">Nama Reseller</th>
                    <th class="pb-3 text-center">Total Produk</th>
                    <th class="pb-3 text-center">Tanggal Pesan</th>
                    <th class="pb-3 text-center">Status Pembayaran</th>
                    <th class="pb-3 text-center">Status Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        {{-- ID Transaksi --}}
                        <td class="py-4 px-2 fw-bold text-dark" style="font-size: 13px;">
                            {{ $pesanan->id_transaksi }}
                        </td>

                        {{-- Nama Reseller (Relasi ke User) --}}
                        <td class="py-4 text-secondary" style="font-size: 14px;">
                            {{ $pesanan->user->nama_lengkap ?? 'Umum' }}
                        </td>

                        {{-- Total Produk + Detail --}}
                        <td class="py-4 text-center" style="font-size: 14px;">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span>{{ $pesanan->total_produk }}</span>
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn-detail-rounded">Lihat Detail</a>
                            </div>
                        </td>
                        
                        {{-- Tanggal --}}
                        <td class="py-4 text-center text-secondary" style="font-size: 14px;">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                        </td>
                        
                        {{-- Status Pembayaran --}}
                        <td class="py-4 text-center">
                            @if($pesanan->payment_status == 'MENUNGGU')
                                <a href="{{ route('pesanan.pay', $pesanan->id) }}" class="text-decoration-none">
                                    <span class="badge bg-warning text-dark px-3 py-2" 
                                        style="cursor: pointer; transition: 0.3s;"
                                        onmouseover="this.style.backgroundColor='#e0a800'; this.style.transform='scale(1.05)';"
                                        onmouseout="this.style.backgroundColor='#ffc107'; this.style.transform='scale(1)';"
                                        title="Klik untuk selesaikan pembayaran">
                                        {{ $pesanan->payment_status }}
                                    </span>
                                </a>
                            @else
                                <span class="badge {{ $pesanan->payment_status == 'LUNAS' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                    {{ $pesanan->payment_status }}
                                </span>
                            @endif
                        </td>
                        
                        {{-- Status Pesanan dengan Warna Figma --}}
                        <td class="py-4 text-center">
                            @php
                                $status = $pesanan->status_pesanan;
                                $bgColor = match($status) {
                                    'Dikemas' => '#E74C3C', 
                                    'Dikirim' => '#F1C40F', 
                                    'Diterima'=> '#2ECC71', 
                                    default   => '#95A5A6'
                                };
                            @endphp
                            <span class="badge-status-rounded" style="background-color: {{ $bgColor }};">
                                {{ strtoupper($status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Data pesanan tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Otomatis Sesuai Figma --}}
    <div class="mt-5 d-flex flex-column align-items-center">
        <div class="d-flex justify-content-between w-100 align-items-center px-2">
            @if ($pesanans->onFirstPage())
                <button class="btn btn-nav-rect" disabled>Sebelumnya</button>
            @else
                <a href="{{ $pesanans->previousPageUrl() }}" class="btn btn-nav-rect">Sebelumnya</a>
            @endif

            <div class="small text-secondary">
                Halaman {{ $pesanans->currentPage() }} dari {{ $pesanans->lastPage() }}
            </div>

            @if ($pesanans->hasMorePages())
                <a href="{{ $pesanans->nextPageUrl() }}" class="btn btn-nav-rect">Selanjutnya</a>
            @else
                <button class="btn btn-nav-rect" disabled>Selanjutnya</button>
            @endif
        </div>
    </div>
</div>

<style>
    .btn-edit-figma { 
        background: #0061F2; 
        color: white !important; 
        border-radius: 8px !important; 
        font-size: 13px; 
        padding: 6px 25px; 
        border: none; 
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-edit-figma:hover { 
        filter: brightness(0.9); 
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-action-outline { 
        background: white; 
        border: 1px solid #D1D5DB; 
        border-radius: 8px !important; 
        color: #4B5563; 
        font-size: 13px; 
        padding: 6px 18px; 
        transition: all 0.3s ease;
    }
    .btn-action-outline:hover { 
        background-color: #f9fafb; 
        border-color: #9CA3AF; 
        color: #111827; 
    }

    .btn-detail-rounded { 
        background: #3B44F6; 
        color: white !important; 
        padding: 5px 15px; 
        font-size: 10px; 
        text-decoration: none; 
        display: inline-block; 
        border-radius: 20px !important; 
        transition: all 0.3s ease;
    }
    .btn-detail-rounded:hover { 
        filter: brightness(0.8); 
        transform: scale(1.05);
    }

    .badge-status-rounded { 
        color: white; padding: 6px 15px; font-size: 9px; font-weight: bold; 
        display: inline-block; min-width: 90px; text-align: center; border-radius: 50px !important; 
        transition: 0.3s;
    }
    .badge-status-rounded:hover { filter: contrast(1.1) brightness(0.9); }

    .payment-status-link {
        color: #4B5563; text-decoration: none; transition: 0.2s;
        border-bottom: 1px dashed #D1D5DB; padding-bottom: 2px;
    }
    .payment-status-link:hover { color: #3B44F6; border-bottom-color: #3B44F6; }
    .btn-nav-rect { border: 1px solid #D1D5DB; border-radius: 5px !important; font-size: 12px; padding: 8px 24px; color: #4B5563; background: white; transition: 0.2s; }
    .btn-nav-rect:hover { background: #f3f4f6; }
    .page-num { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #D1D5DB; border-radius: 5px !important; font-size: 12px; background: white; }
    .page-num.active { background: #DBEafe; color: #2563EB; border-color: #BFDBFE; font-weight: bold; }
    .text-secondary { color: #6B7280 !important; }
</style>
@endsection