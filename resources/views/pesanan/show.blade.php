@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Detail Pesanan: BRS-{{ date('Y') }}-{{ str_pad($pesanan->id, 3, '0', STR_PAD_LEFT) }}</h3>
        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary shadow-sm" style="border-radius: 8px;">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
        <div class="row">
            {{-- Informasi Pelanggan --}}
            <div class="col-md-6">
                <h5 class="text-muted mb-3" style="font-size: 14px; letter-spacing: 1px;">INFORMASI PELANGGAN</h5>
                <p>Nama Reseller: <strong>{{ $pesanan->user->nama_lengkap ?? 'Nama Tidak Terdeteksi' }}</strong></p>
                <p><strong>Wilayah:</strong> {{ $pesanan->user->alamat ?? '-' }}</p>
                <p><strong>No. Telepon:</strong> {{ $pesanan->user->no_telepon ?? '-' }}</p>
            </div>
            
            {{-- Status Transaksi --}}
            <div class="col-md-6 text-md-end">
                <h5 class="text-muted mb-3" style="font-size: 14px; letter-spacing: 1px;">STATUS TRANSAKSI</h5>
                <p class="mb-1"><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d F Y') }}</p>
                <p>Status Pembayaran: 
                    <a href="{{ route('pesanan.pay', $pesanan->id) }}" class="text-decoration-none">
                        <span class="badge bg-warning text-dark">{{ $pesanan->payment_status }}</span>
                    </a>
                </p>
            </div>
        </div>

        <hr class="my-4" style="border-color: #F3F4F6;">

        <h5 class="text-muted border-bottom pb-2">RINGKASAN PRODUK</h6>
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th>Total Item</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan (Avg)</th>
                        <th class="text-end text-dark">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">{{ $pesanan->total_produk }} Unit</td>
                        <td>Es Krim & Kopi</td>
                        {{-- Kita hitung manual harga satuannya --}}
                        <td>Rp{{ number_format($pesanan->total_harga / $pesanan->total_produk, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-danger" style="font-size: 1.2rem;">
                            Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- Section Pembayaran Midtrans --}}
        @if($pesanan->payment_status !== 'Berhasil')
        <div class="p-4 bg-light rounded-3 text-center border">
            <h5 class="fw-bold mb-2">Selesaikan Pembayaran</h5>
            <p class="text-muted mb-3">Klik tombol di bawah untuk membayar melalui Midtrans secara aman.</p>
            
            {{-- Tombol Bayar --}}
            <a href="{{ route('pesanan.pay', $pesanan->id) }}" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="fas fa-wallet me-2"></i> Bayar Sekarang
            </a>
            
            {{-- Wadah Embed Midtrans --}}
            <div id="snap-container" class="mt-4"></div>
        </div>
        @else
        <div class="p-4 bg-light rounded-3 text-center border">
            <h5 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-circle-check me-2"></i>Pembayaran Sudah Selesai
            </h5>
        </div>
        @endif
    </div>
</div>

{{-- Script Midtrans --}}
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    if(payButton) {
        payButton.addEventListener('click', function () {
            window.snap.embed('{{ $snapToken }}', {
                embedId: 'snap-container',
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!"); 
                    window.location.reload();
                },
                onPending: function(result){
                    alert("Menunggu Pembayaran..."); 
                },
                onError: function(result){
                    alert("Pembayaran Gagal!"); 
                }
            });
        });
    }
</script>

<style>
    .bg-success { background-color: #2ECC71 !important; }
    .bg-warning { background-color: #F1C40F !important; }
    .btn-primary { background-color: #E31E24 !important; border: none; }
    .btn-primary:hover { background-color: #E31E24 !important; }
</style>
@endsection

{{-- --- LETAKKAN DI SINI --- --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}');
    });
</script>
