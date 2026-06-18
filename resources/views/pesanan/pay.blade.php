@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-5 text-center">
                    <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" width="120" class="mb-4">
                    
                    <h4 class="fw-bold text-dark">Konfirmasi Pembayaran</h4>
                    <p class="text-muted">Satu langkah lagi untuk menyelesaikan pesanan Anda.</p>
                    
                    <hr class="my-4" style="border-top: 2px dashed #eee;">

                    <div class="text-start mb-4 bg-light p-3" style="border-radius: 10px;">
                        <div class="d-flex justify-content-between mb-2">
                            <span>ID Transaksi:</span>
                            <span class="fw-bold">{{ $pesanan->id_transaksi }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk:</span>
                            <span class="fw-bold">{{ $pesanan->total_produk }} Unit</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Tagihan:</span>
                            <span class="fw-bold text-danger" style="font-size: 1.2rem;">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="small text-muted mb-4">
                        Klik tombol di bawah untuk membuka jendela pembayaran aman Midtrans.
                    </p>

                    <button id="pay-button" class="btn btn-danger w-100 py-3 fw-bold border-0 shadow-sm" 
                            style="background-color: #E31E24; transition: 0.3s; border-radius: 10px;"
                            onmouseover="this.style.backgroundColor='#b3171b'; this.style.boxShadow='0 4px 15px rgba(227, 30, 36, 0.4)';"
                            onmouseout="this.style.backgroundColor='#E31E24'; this.style.boxShadow='none';">
                        <i class="fas fa-credit-card me-2"></i> BAYAR SEKARANG
                    </button>

                    <a href="{{ route('pesanan.cancel.confirm', $pesanan->id) }}"
                    class="btn btn-link text-muted link-danger fw-bold mt-3 text-decoration-none">
                    <i class="fas fa-times me-1"></i> Batalkan Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // snapToken dikirim dari Controller
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('pesanan.index') }}";
                alert("Pembayaran berhasil!");
            },
            onPending: function(result){
                location.reload();
            },
            onError: function(result){
                alert("Pembayaran gagal, silakan coba lagi.");
            },
            onClose: function(){
                alert('Anda menutup jendela pembayaran sebelum selesai.');
            }
        });
    });
</script>
@endsection