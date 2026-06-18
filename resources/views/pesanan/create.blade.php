@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0" style="font-family: 'Montserrat', sans-serif;">Tambah Pesanan Baru</h4>
        <a href="{{ route('pesanan.index') }}" class="btn btn-action-outline">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm p-5" style="border-radius: 0; background: rgba(255,255,255,0.95);">
        <form action="{{ route('pesanan.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Bagian Kiri: Data Pelanggan --}}
                <div class="col-md-6 border-end pe-md-5">
                    <h5 class="fw-bold mb-4 small tracking-widest text-secondary">DATA PELANGGAN</h5>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">NAMA PELANGGAN / RESELLER</label>
                        <input type="text" name="nama_pelanggan" class="form-control custom-input" placeholder="Contoh: Duta Agam" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">NO. TELEPON</label>
                        <input type="text" name="no_hp" class="form-control custom-input" placeholder="0812xxxx" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">ALAMAT LENGKAP</label>
                        <textarea name="alamat" class="form-control custom-input" rows="3" placeholder="Jl. Bobosan No. 10..."></textarea>
                    </div>
                </div>

                {{-- Bagian Kanan: Detail Pesanan --}}
                <div class="col-md-6 ps-md-5">
                    <h5 class="fw-bold mb-4 small tracking-widest text-secondary">DETAIL PESANAN & PEMBAYARAN</h5>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">TOTAL PRODUK (QTY)</label>
                        <input type="number" name="total_produk" class="form-control custom-input" placeholder="Contoh: 100" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-dark">STATUS PEMBAYARAN</label>
                            <select name="payment_status" class="form-select custom-input">
                                <option value="MENUNGGU">MENUNGGU</option>
                                <option value="BERHASIL">BERHASIL</option>
                                <option value="GAGAL">GAGAL</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-dark">STATUS PESANAN</label>
                            <select name="status" class="form-select custom-input">
                                <option value="Dikemas">Dikemas</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Diterima">Diterima</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">PAYMENT LINK (MIDTRANS)</label>
                        <input type="text" name="payment_url" class="form-control custom-input" placeholder="https://app.midtrans.com/...">
                        <div class="form-text small italic">Kosongkan jika ingin digenerate otomatis nanti.</div>
                    </div>
                </div>
            </div>

            <div class="mt-5 border-top pt-4 text-end">
                <button type="submit" class="btn btn-save-figma px-5">SIMPAN PESANAN</button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-input {
        border-radius: 0 !important;
        border: 1px solid #D1D5DB;
        padding: 12px;
        font-size: 14px;
        background-color: #F9FAFB;
    }
    .custom-input:focus {
        border-color: #0061F2;
        box-shadow: none;
        background-color: #fff;
    }
    .btn-save-figma {
        background: #0061F2;
        color: white !important;
        font-weight: bold;
        padding: 12px 30px;
        border-radius: 0 !important;
        border: none;
        letter-spacing: 1px;
    }
    .btn-action-outline {
        border: 1px solid #D1D5DB;
        background: white;
        border-radius: 0 !important;
        padding: 8px 15px;
        font-size: 13px;
        color: #4B5563;
    }
    .form-label { letter-spacing: 0.5px; }
</style>
@endsection