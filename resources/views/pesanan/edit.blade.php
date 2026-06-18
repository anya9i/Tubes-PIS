@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0" style="font-family: 'Montserrat', sans-serif;">
            Edit Pesanan: <span class="text-primary">{{ $pesanan->nama_pelanggan }}</span>
        </h4>
        <a href="{{ route('pesanan.index') }}" class="btn btn-action-outline">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm p-5" style="border-radius: 0; background: rgba(255,255,255,0.95);">
        {{-- Action mengarah ke update dengan ID --}}
        <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Syarat wajib untuk proses update --}}

            {{-- ... bagian atas (header) ... --}}

    <div class="row">
        <!-- {{-- Bagian Kiri: Data Pelanggan --}}
        <div class="col-md-6 border-end pe-md-5">
            <h5 class="fw-bold mb-4 small tracking-widest text-secondary">DATA PELANGGAN</h5>
            
            {{-- GANTI BLOK INI --}}
            <div class="mb-4">
                <label class="form-label small fw-bold text-dark">NAMA PELANGGAN / RESELLER</label>
                <input type="text" class="form-control custom-input bg-light" 
                    value="{{ $pesanan->user->nama_lengkap ?? $pesanan->nama_pelanggan }}" readonly>
                
                {{-- Hidden input supaya datanya tetap terkirim saat form disubmit --}}
                <input type="hidden" name="nama_pelanggan" value="{{ $pesanan->nama_pelanggan }}">
                
                <div class="form-text small italic">Nama pelanggan tidak dapat diubah dari halaman ini.</div>
            </div>
            {{-- AKHIR DARI PERUBAHAN --}}

        <div class="mb-4">
            <label class="form-label small fw-bold text-dark">NO. TELEPON</label>
            <input type="text" name="no_hp" class="form-control custom-input" 
                   value="{{ old('no_hp', $pesanan->no_hp) }}" required>
        </div> -->

        {{-- Bagian Kiri: Data Pelanggan --}}
<div class="col-md-6 border-end pe-md-5">
    <h5 class="fw-bold mb-4 small tracking-widest text-secondary">DATA PELANGGAN</h5>
    
    <div class="mb-4">
        <label class="form-label small fw-bold text-dark">NAMA PELANGGAN (MANUAL)</label>
        {{-- Kita hapus 'readonly' dan 'bg-light' agar bisa diketik --}}
        <input type="text" name="nama_pelanggan" class="form-control custom-input" 
               value="{{ old('nama_pelanggan', $pesanan->nama_pelanggan) }}" required>
        <div class="form-text small italic">Gunakan ini jika pelanggan bukan reseller tetap.</div>
    </div>

    <div class="mb-4">
        <label class="form-label small fw-bold text-dark">HUBUNGKAN KE RESELLER (OPSIONAL)</label>
        {{-- Ini untuk mengganti relasi reseller jika salah pilih --}}
        <select name="user_id" class="form-select custom-input">
            <option value="">-- Pilih Jika Reseller --</option>
            @foreach($resellers as $reseller)
                <option value="{{ $reseller->id }}" 
                    {{ (old('user_id', $pesanan->user_id) == $reseller->id) ? 'selected' : '' }}>
                    {{ $reseller->nama_reseller ?? $reseller->nama_lengkap }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="form-label small fw-bold text-dark">NO. TELEPON</label>
        <input type="text" name="no_hp" class="form-control custom-input" 
               value="{{ old('no_hp', $pesanan->no_hp) }}" required>
    </div>

    <div class="mb-4">
        <label class="form-label small fw-bold text-dark">ALAMAT LENGKAP</label>
        <textarea name="alamat" class="form-control custom-input" rows="3">{{ old('alamat', $pesanan->alamat) }}</textarea>
    </div>
</div>

{{-- ... sisa kode lainnya ... --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">PILIH RESELLER / PELANGGAN</label>
                        <select name="user_id" class="form-select custom-input" required>
                            <option value="">-- Pilih Reseller --</option>
                            @foreach($resellers as $reseller)
                                <option value="{{ $reseller->id }}" 
                                    {{ (old('user_id', $pesanan->user_id) == $reseller->id) ? 'selected' : '' }}>
                                    {{ $reseller->nama_lengkap }} ({{ $reseller->kode_reseller ?? 'Reseller' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">ALAMAT LENGKAP</label>
                        <textarea name="alamat" class="form-control custom-input" rows="3">{{ old('alamat', $pesanan->alamat) }}</textarea>
                    </div>
                </div>

                {{-- Bagian Kanan: Detail Pesanan --}}
                <div class="col-md-6 ps-md-5">
                    <h5 class="fw-bold mb-4 small tracking-widest text-secondary">DETAIL PESANAN & PEMBAYARAN</h5>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">TOTAL PRODUK (QTY)</label>
                        <input type="number" name="total_produk" class="form-control custom-input" 
                               value="{{ old('total_produk', $pesanan->total_produk) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-dark">STATUS PEMBAYARAN</label>
                            <select name="payment_status" class="form-select custom-input">
                                <option value="MENUNGGU" {{ $pesanan->payment_status == 'MENUNGGU' ? 'selected' : '' }}>MENUNGGU</option>
                                <option value="BERHASIL" {{ $pesanan->payment_status == 'BERHASIL' ? 'selected' : '' }}>BERHASIL</option>
                                <option value="GAGAL" {{ $pesanan->payment_status == 'GAGAL' ? 'selected' : '' }}>GAGAL</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-dark">STATUS PESANAN</label>
                            <select name="status" class="form-select custom-input">
                                <option value="Dikemas" {{ $pesanan->status == 'Dikemas' ? 'selected' : '' }}>Dikemas</option>
                                <option value="Dikirim" {{ $pesanan->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="Diterima" {{ $pesanan->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                    <label class="form-label small fw-bold text-dark">PAYMENT LINK (MIDTRANS)</label>
                    <input type="text" name="payment_url" class="form-control custom-input" 
                        value="{{ old('payment_url', $pesanan->payment_url) }}" 
                        placeholder="https://app.midtrans.com/...">
                    <div class="form-text small italic">Admin bisa memperbarui link jika link sebelumnya kedaluwarsa.</div>
                </div>
                </div>
            </div>

            <div class="mt-5 border-top pt-4 text-end">
                <button type="submit" class="btn btn-update-figma px-5">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Style tetap konsisten dengan create & index (Rectangle/Kaku) */
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
    .btn-update-figma {
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .form-label { letter-spacing: 0.5px; }
</style>
@endsection