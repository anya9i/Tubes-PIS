@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Integrasi Font Utama */
    .interface-pesanan-wrapper {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Card Papan Putih Utama */
    .card-pesanan-custom {
        border-radius: 15px; 
        background: #ffffff;
        border: 1px solid #E5E7EB !important; /* Batas border halus luar */
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    /* Judul Utama */
    .judul-status-pesanan {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
    }

    /* Tombol Edit Biru */
    .btn-edit-figma { 
        background: #0061F2 !important; 
        color: #ffffff !important; 
        border-radius: 8px !important; 
        font-size: 13px; 
        padding: 6px 22px; 
        border: none !important; 
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.2s ease;
    }
    .btn-edit-figma:hover { 
        background-color: #004ec2 !important;
    }
    .btn-edit-figma[disabled] {
        background-color: #9CA3AF !important;
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Tombol Aksi Kanan (Sort & Download dengan Kotak Outline Jelas) */
    .btn-action-outline-figma { 
        background: #ffffff !important; 
        border: 1px solid #D1D5DB !important; /* Kotak luar abu-abu terlihat jelas */
        border-radius: 8px !important; 
        color: #4B5563 !important; 
        font-size: 13px; 
        padding: 6px 16px; 
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-action-outline-figma:hover { 
        background-color: #F9FAFB !important; 
        border-color: #9CA3AF !important; 
        color: #111827 !important;
    }

    /* Kolom Header Tabel */
    .tabel-status-style thead th {
        color: #383E49 !important;
        font-weight: 700 !important;
        font-size: 13px;
        letter-spacing: -0.1px;
        border-bottom: 2px solid #E5E7EB !important;
    }

    /* Tombol Lihat Detail Kapsul */
    .btn-detail-pill { 
        background: #3B44F6 !important; 
        color: #ffffff !important; 
        padding: 4px 14px; 
        font-size: 11px; 
        font-weight: 600;
        text-decoration: none; 
        display: inline-block; 
        border-radius: 20px !important; 
        transition: opacity 0.2s ease;
    }
    .btn-detail-pill:hover { 
        opacity: 0.9;
        color: #ffffff !important;
    }

    /* Badge Bulat Status Pesanan */
    .badge-status-kapsul { 
        color: #ffffff; 
        padding: 5px 14px; 
        font-size: 10px; 
        font-weight: 700; 
        display: inline-block; 
        min-width: 85px; 
        text-align: center; 
        border-radius: 50px !important; 
    }

    /* Tombol Kotak Navigasi Pagination */
    .btn-nav-pagination { 
        border: 1px solid #D1D5DB !important; 
        border-radius: 6px !important; 
        font-size: 12px; 
        padding: 6px 20px; 
        color: #4B5563; 
        background: #ffffff; 
        font-weight: 600;
        transition: background-color 0.2s ease;
    }
    .btn-nav-pagination:hover:not([disabled]) { 
        background-color: #F3F4F6; 
    }
    .btn-nav-pagination[disabled] {
        color: #9CA3AF;
        cursor: not-allowed;
    }
</style>

<div class="card border-0 shadow-sm p-4 card-pesanan-custom interface-pesanan-wrapper">
    
    {{-- Bagian Atas / Header Kontrol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="judul-status-pesanan m-0">Status Pesanan</h4>
        <div class="d-flex gap-2">
            
            {{-- BARIKADE HAK AKSES: Hanya admin/super admin yang bisa memicu fitur Edit --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super admin')
                @if($pesanans->count() > 0)
                    <a href="{{ route('pesanan.edit', $pesanans[0]->id) }}" class="btn btn-edit-figma">Edit</a>
                @else
                    <button class="btn btn-edit-figma" disabled>Edit</button>
                @endif
            @endif

            {{-- Tombol Sortir Tanggal Pesanan --}}        
            {{-- Tombol Download dengan Garis Kotak Terang --}}
            <button class="btn btn-action-outline-figma" onclick="jalankanEksporUnduhCSV()">
                <i class="bi bi-download" style="color: #707680; font-size: 12px;"></i>
                <span>Download</span>
            </button>
        </div>
    </div>

    {{-- Wadah Responsif Tabel Data --}}
    <div class="table-responsive">
        <table id="mainTabelPesananFigma" class="table align-middle border-0 tabel-status-style">
            <thead>
                <tr>
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
                        {{-- Kode ID Transaksi --}}
                        <td class="py-4 px-2 fw-bold" style="font-size: 13px; color: #383E49;">
                            {{ $pesanan->id_transaksi }}
                        </td>

                        {{-- Nama Pengguna Reseller --}}
                        <td class="py-4 text-secondary" style="font-size: 14px; font-weight: 500; color: #4B5563 !important;">
                            {{ $pesanan->user->nama_lengkap ?? 'Umum' }}
                        </td>

                        {{-- Jumlah Unit Produk + Aksi Detail --}}
                        <td class="py-4 text-center" style="font-size: 14px;">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <span class="fw-semibold" style="color: #383E49;">{{ $pesanan->total_produk }}</span>
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn-detail-pill">Lihat Detail</a>
                            </div>
                        </td>
                        
                        {{-- Waktu Pesanan (Mendukung Data Timestamp untuk Penyortiran Akurat) --}}
                        <td class="py-4 text-center text-secondary kolom-tanggal-data" data-waktu="{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->timestamp }}" style="font-size: 14px; font-weight: 500; color: #4B5563 !important;">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                        </td>
                        
                        {{-- Status Kelunasan Gerbang Pembayaran --}}
                        <td class="py-4 text-center">
                            @if(strtoupper($pesanan->payment_status) == 'MENUNGGU')
                                <a href="{{ route('pesanan.pay', $pesanan->id) }}" class="text-decoration-none">
                                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold" style="border-radius: 4px; font-size: 11px; cursor: pointer;">
                                        {{ $pesanan->payment_status }}
                                    </span>
                                </a>
                            @else
                                <span class="badge {{ strtoupper($pesanan->payment_status) == 'LUNAS' || strtoupper($pesanan->payment_status) == 'BERHASIL' ? 'bg-success text-white' : 'bg-secondary text-white' }} px-3 py-2 fw-bold" style="border-radius: 4px; font-size: 11px;">
                                    {{ $pesanan->payment_status }}
                                </span>
                            @endif
                        </td>
                        
                        {{-- Badge Status Proses Sesuai Palet Warna Gambar --}}
                        <td class="py-4 text-center">
                            @php
                                $statusText = strtolower($pesanan->status_pesanan);
                                $warnaSistem = match($statusText) {
                                    'dikemas' => '#E74C3C', 
                                    'dikirim' => '#F1C40F', 
                                    'diterima'=> '#2ECC71', 
                                    default   => '#95A5A6'
                                };
                            @endphp
                            <span class="badge-status-kapsul" style="background-color: {{ $warnaSistem }};">
                                {{ strtoupper($pesanan->status_pesanan) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fw-semibold" style="font-size: 14px;">Data transaksi pesanan belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bagian Bawah / Navigasi Halaman Terintegrasi --}}
    <div class="mt-4 d-flex flex-column align-items-center">
        <div class="d-flex justify-content-between w-100 align-items-center px-1">
            @if ($pesanans->onFirstPage())
                <button class="btn btn-nav-pagination" disabled>Sebelumnya</button>
            @else
                <a href="{{ $pesanans->previousPageUrl() }}" class="btn btn-nav-pagination">Sebelumnya</a>
            @endif

            <div class="small fw-semibold text-secondary" style="color: #6B7280 !important; font-size: 13px;">
                Halaman {{ $pesanans->currentPage() }} dari {{ $pesanans->lastPage() }}
            </div>

            @if ($pesanans->hasMorePages())
                <a href="{{ $pesanans->nextPageUrl() }}" class="btn btn-nav-pagination">Selanjutnya</a>
            @else
                <button class="btn btn-nav-pagination" disabled>Selanjutnya</button>
            @endif
        </div>
    </div>
</div>

{{-- Blok Logika Kode Fitur Sortir & Download --}}
<script>
    // 1. Logika Sort Tanggal Pesanan (Urutan Atas/Bawah Bergantian)
    let urutanMaju = true;
    function jalankanSortirTanggalLive() {
        const wadahTabel = document.getElementById("mainTabelPesananFigma");
        const badanTabel = wadahTabel.querySelector('tbody');
        const kumpulanBaris = Array.from(badanTabel.querySelectorAll("tr"));
        
        // Lewati penyortiran jika tabel kosong
        if(kumpulanBaris.length === 1 && kumpulanBaris[0].cells.length === 1) return;
        
        kumpulanBaris.sort((barisX, barisY) => {
            const dataX = barisX.querySelector('.kolom-tanggal-data');
            const dataY = barisY.querySelector('.kolom-tanggal-data');
            if (!dataX || !dataY) return 0;
            
            const nilaiWaktuX = parseInt(dataX.getAttribute('data-waktu'));
            const nilaiWaktuY = parseInt(dataY.getAttribute('data-waktu'));
            return urutanMaju ? nilaiWaktuX - nilaiWaktuY : nilaiWaktuY - nilaiWaktuX;
        });
        
        urutanMaju = !urutanMaju; // Balikkan urutan untuk klik berikutnya
        kumpulanBaris.forEach(baris => badanTabel.appendChild(baris));
    }

    // 2. Logika Download Ekspor Excel/CSV Seluruh Baris Data Tabel
    function jalankanEksporUnduhCSV() {
        let komponenBarisCsv = ['ID Transaksi,Nama Reseller,Total Produk,Tanggal Pesan,Status Pembayaran,Status Pesanan'];
        const barisDataTabel = document.querySelectorAll("#mainTabelPesananFigma tbody tr");
        
        barisDataTabel.forEach(baris => {
            if(baris.cells.length >= 6) {
                const elemenTanggal = baris.querySelector('.kolom-tanggal-data');
                
                let strukturKolom = [
                    '"' + baris.cells[0].innerText.trim() + '"',
                    '"' + baris.cells[1].innerText.trim() + '"',
                    '"' + baris.cells[2].querySelector('span').innerText.trim() + '"',
                    elemenTanggal ? elemenTanggal.innerText.trim() : baris.cells[3].innerText.trim(),
                    '"' + baris.cells[4].innerText.trim() + '"',
                    '"' + baris.cells[5].innerText.trim() + '"'
                ];
                komponenBarisCsv.push(strukturKolom.join(','));
            }
        });
        
        // Proses pembuatan dokumen file unduhan
        let blobDokumen = new Blob([komponenBarisCsv.join('\n')], {type: "text/csv;charset=utf-8;"});
        let tautanPemicu = document.createElement("a");
        tautanPemicu.download = "Laporan_Status_Pesanan_" + new Date().toISOString().slice(0,10) + ".csv";
        tautanPemicu.href = window.URL.createObjectURL(blobDokumen);
        tautanPemicu.style.display = "none";
        document.body.appendChild(tautanPemicu);
        tautanPemicu.click();
        document.body.removeChild(tautanPemicu);
    }
</script>
@endsection