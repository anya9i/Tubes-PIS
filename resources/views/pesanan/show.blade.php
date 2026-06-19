@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .interface-detail-wrapper {
        font-family: 'Montserrat', sans-serif !important;
        padding: 40px 30px;
    }

    /* Papan Putih Detail Konten */
    .papan-detail-putih {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        padding: 40px;
        border: 1px solid #dee2e6 !important; /* Dipertegas agar kotak terlihat */
    }

    /* Judul Utama */
    .judul-detail-asli {
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
        letter-spacing: -0.2px;
    }

    .sub-judul-parameter {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
        letter-spacing: 0.5px;
    }

    .teks-data-detail {
        font-size: 14px !important;
        font-weight: 500;
        color: #6c757d !important;
    }

    /* Memastikan Outline/Border Tombol Terlihat Jelas */
    .btn-outline-custom {
        border: 1px solid #ced4da !important; /* Garis kotak dipertegas */
        background-color: #ffffff !important;
        color: #495057 !important;
        border-radius: 6px !important;
        font-size: 0.85rem;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-outline-custom:hover {
        background-color: #f8f9fa !important;
        border-color: #adb5bd !important;
    }

    /* Tombol Kembali / Sekunder */
    .btn-kembali-custom {
        background-color: #6c757d !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 6px !important;
        font-size: 0.85rem;
        padding: 8px 16px;
        font-weight: 600;
    }

    .btn-kembali-custom:hover {
        background-color: #5a6268 !important;
    }
</style>

<div class="container-fluid bg-transparent interface-detail-wrapper">
    
    {{-- Header Atas --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="judul-detail-asli m-0">
            Detail Pesanan: BRS-{{ date('Y') }}-{{ str_pad($pesanan->id, 3, '0', STR_PAD_LEFT) }}
        </h3>
        
        <div class="d-flex gap-2">
            <button class="btn btn-outline-custom d-flex align-items-center gap-2" onclick="sortDetailLive()">
                <i class="bi bi-arrow-down-up" style="color: #6c757d;"></i> Sort
            </button>
            
            <button class="btn btn-outline-custom d-flex align-items-center gap-2" onclick="unduhDetailTXT()">
                <i class="bi bi-download" style="color: #6c757d;"></i> Download
            </button>

            <a href="{{ route('pesanan.index') }}" class="btn btn-kembali-custom d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Blok Papan Informasi Utama --}}
    <div class="papan-detail-putih mb-4">
        <div class="row">
            {{-- Informasi Pelanggan --}}
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="sub-judul-parameter mb-3">INFORMASI PELANGGAN</h5>
                <p class="teks-data-detail mb-2">Nama Reseller: <strong class="text-dark" id="download-nama">{{ $pesanan->user->nama_lengkap ?? 'Nama Tidak Terdeteksi' }}</strong></p>
                <p class="teks-data-detail mb-2">Wilayah / Alamat: <span class="text-dark" id="download-alamat">{{ $pesanan->user->alamat ?? '-' }}</span></p>
                <p class="teks-data-detail mb-0">No. Telepon: <span class="text-dark" id="download-telepon">{{ $pesanan->user->no_telepon ?? '-' }}</span></p>
            </div>
            
            {{-- Status Transaksi --}}
            <div class="col-md-6 text-md-end">
                <h5 class="sub-judul-parameter mb-3">STATUS TRANSAKSI</h5>
                <p class="teks-data-detail mb-2">Tanggal Pesan: <span class="text-dark" id="download-tanggal">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d F Y') }}</span></p>
                <p class="teks-data-detail mb-0">Status Pembayaran: 
                    @if(strtoupper($pesanan->payment_status) == 'LUNAS' || strtoupper($pesanan->payment_status) == 'BERHASIL')
                        <span class="badge bg-success text-white px-3 py-1.5 fw-semibold" style="border-radius: 4px; font-size: 12px;">LUNAS</span>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-1.5 fw-semibold" style="border-radius: 4px; font-size: 12px;">{{ $pesanan->payment_status }}</span>
                    @endif
                </p>
            </div>
        </div>

        <hr class="my-4" style="border-color: #dee2e6;">

        <h5 class="sub-judul-parameter mb-3">RINGKASAN PRODUK</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle" id="tabelDetailProduk" style="border-color: #dee2e6 !important;">
                <thead>
                    <tr class="bg-light">
                        <th class="py-3 teks-data-detail fw-bold text-dark">Total Item</th>
                        <th class="py-3 teks-data-detail fw-bold text-dark">Nama Produk</th>
                        <th class="py-3 teks-data-detail fw-bold text-dark text-center">Harga Satuan (Avg)</th>
                        <th class="py-3 teks-data-detail fw-bold text-dark text-end">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3 teks-data-detail fw-bold text-dark" id="download-qty">{{ $pesanan->total_produk }} Unit</td>
                        <td class="py-3 teks-data-detail">Es Krim & Kopi Brasil</td>
                        <td class="py-3 teks-data-detail text-center">
                            Rp {{ number_format($pesanan->total_produk > 0 ? ($pesanan->total_harga / $pesanan->total_produk) : 0, 0, ',', '.') }}
                        </td>
                        <td class="py-3 text-end fw-bold text-danger" style="font-size: 1.15rem;" id="download-total">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Section Pembayaran Midtrans Sandbox --}}
        @if(strtoupper($pesanan->payment_status) !== 'LUNAS' && strtoupper($pesanan->payment_status) !== 'BERHASIL')
            <div class="p-4 bg-light rounded text-center border mt-4" style="border-radius: 6px !important; border-color: #dee2e6 !important;">
                <h5 class="fw-bold text-dark mb-2" style="font-size: 15px;">Selesaikan Pembayaran</h5>
                <p class="text-muted small mb-4">Klik tombol di bawah untuk membayar melalui gerbang pembayaran Midtrans secara aman.</p>
                
                <button id="pay-button" class="btn btn-primary w-100 py-2.5 fw-bold text-white border-0" style="background-color: #E31E24 !important; border-radius: 6px;">
                    <i class="bi bi-wallet2 me-2"></i> Bayar Sekarang via Midtrans
                </button>
                
                <div id="snap-container" class="mt-4"></div>
            </div>
        @else
            <div class="p-4 bg-light rounded text-center border mt-4" style="border-radius: 6px !important; border-color: #dee2e6 !important;">
                <h5 class="fw-bold text-success mb-0" style="font-size: 15px;">
                    <i class="bi bi-check-circle-fill me-2"></i> Transaksi Berhasil. Pembayaran Telah Diselesaikan.
                </h5>
            </div>
        @endif
    </div>
</div>

{{-- Script Load SDK Midtrans Snap --}}
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var payButton = document.getElementById('pay-button');
        if(payButton && '{{ $snapToken ?? "" }}' !== '') {
            payButton.addEventListener('click', function (e) {
                e.preventDefault();
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        alert("Pembayaran sukses dikonfirmasi!"); 
                        window.location.reload();
                    },
                    onPending: function(result){
                        alert("Menunggu penyelesaian pembayaran oleh reseller..."); 
                        window.location.reload();
                    },
                    onError: function(result){
                        alert("Proses transaksi pembayaran gagal dilakukan!"); 
                    }
                });
            });
        }
    });

    function sortDetailLive() {
        alert("Halaman ini merupakan ringkasan satu nota tunggal transaksi. Tidak ada data baris lain untuk disortir.");
    }

    function unduhDetailTXT() {
        let nomorNota = "BRS-{{ date('Y') }}-{{ str_pad($pesanan->id, 3, '0', STR_PAD_LEFT) }}";
        let nama = document.getElementById('download-nama').innerText;
        let alamat = document.getElementById('download-alamat').innerText;
        let telepon = document.getElementById('download-telepon').innerText;
        let tanggal = document.getElementById('download-tanggal').innerText;
        let qty = document.getElementById('download-qty').innerText;
        let total = document.getElementById('download-total').innerText;
        let statusBayar = "{{ $pesanan->payment_status }}";

        let textKonten = 
            "=========================================\n" +
            "       NOTA DETAIL PESANAN - ES KOPI BRASIL\n" +
            "=========================================\n" +
            "Nomor Nota     : " + nomorNota + "\n" +
            "Tanggal Pesan  : " + tanggal + "\n" +
            "Status Bayar   : " + statusBayar + "\n" +
            "-----------------------------------------\n" +
            "DATA PELANGGAN / RESELLER:\n" +
            "Nama Lengkap   : " + nama + "\n" +
            "Alamat Wilayah : " + alamat + "\n" +
            "No. Telepon    : " + telepon + "\n" +
            "-----------------------------------------\n" +
            "RINKASAN ITEM PRODUK:\n" +
            "Nama Produk    : Es Krim & Kopi Brasil\n" +
            "Kuantitas Qty  : " + qty + "\n" +
            "Total Tagihan  : " + total + "\n" +
            "=========================================\n" +
            "Terima kasih telah mempercayai Es Kopi Brasil!";

        let blob = new Blob([textKonten], {type: "text/plain;charset=utf-8;"});
        let link = document.createElement("a");
        link.download = "Invoice_Detail_" + nomorNota + ".txt";
        link.href = window.URL.createObjectURL(blob);
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection