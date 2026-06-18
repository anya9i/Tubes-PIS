@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="text-warning mb-4">
                        <i class="fas fa-exclamation-triangle fa-4x" style="color: #ffc107;"></i>
                    </div>
                    
                    <h4 class="fw-bold text-dark">Yakin Membatalkan Pembayaran?</h4>
                    <p class="text-muted">Pesanan Anda tidak akan diproses jika Anda meninggalkan halaman ini.</p>
                    
                    <div class="bg-light p-3 my-4" style="border-radius: 10px; border: 1px solid #eee;">
                        <small class="text-muted d-block text-uppercase" style="font-size: 10px; letter-spacing: 1px;">ID Transaksi</small>
                        <span class="fw-bold text-dark">{{ $pesanan->id_transaksi }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-danger py-2 fw-bold" style="background-color: #E31E24; border-radius: 8px;">
                            Ya, Batalkan
                        </a>
                        
                        <a href="{{ route('pesanan.pay', $pesanan->id) }}" class="btn btn-outline-secondary py-2" style="border-radius: 8px;">
                            Tidak, Lanjutkan Bayar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection