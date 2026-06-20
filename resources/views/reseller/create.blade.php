@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reseller.css') }}">

<div class="content" style="font-family: 'Montserrat', sans-serif;">
    <div class="form-card">

        <h2 class="form-title">TAMBAH DATA RESELLER</h2>

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius: 0px !important; background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; font-weight: 600; font-size: 13px;">
                <ul class="mb-0" style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reseller.store') }}" method="POST">
            @csrf

            {{-- PROFIL UTAMA --}}
            <div class="form-group full">
                <label>Nama Lengkap Reseller <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Isi Nama Lengkap Sesuai KTP" required>
            </div>

            {{-- KREDENSIAL LOGIN AKUN (WAJIB ADA AGAR BISA LOGIN) --}}
            <div class="form-grid">
                <div class="form-group">
                    <label>Username Akun <span class="text-danger">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: kalala_brasil" required>
                </div>

                <div class="form-group">
                    <label>Email Terdaftar <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: reseller@gmail.com" required>
                </div>
            </div>

            <div class="form-group full">
                <label>Password Akun Reseller <span class="text-danger">*</span></label>
                <input type="password" name="password" placeholder="Minimal 6 Karakter Rahasia" required>
            </div>

            {{-- PARAMETER WILAYAH & JENIS TOKO --}}
            <div class="form-grid">
                <div class="form-group">
                    <label>Jenis Kemitraan Toko</label>
                    <select name="jenis_toko">
                        <option value="">Pilih Jenis Toko</option>
                        <option value="Agen" {{ old('jenis_toko') == 'Agen' ? 'selected' : '' }}>Agen Resmi</option>
                        <option value="Reseller" {{ old('jenis_toko') == 'Reseller' ? 'selected' : '' }}>Reseller Biasa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Wilayah Distribusi</label>
                    <input type="text" name="wilayah" value="{{ old('wilayah') }}" placeholder="Contoh: Purwokerto Timur">
                </div>
            </div>

            {{-- ALAMAT DOMISILI --}}
            <div class="form-group full">
                <label>Alamat Lengkap Rumah/Toko</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kecamatan">
            </div>

            {{-- TELEPON --}}
            <div class="form-group">
                <label>No. Telepon Aktif (WhatsApp) <span class="text-danger">*</span></label>
                <input 
                    type="text"
                    name="no_telepon"
                    value="{{ old('no_telepon') }}"
                    placeholder="Contoh: 081234567890"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    required
                >
            </div>

            {{-- BUTTON AKSI KOTAK TEGAS --}}
            <div class="form-actions pt-3">
                <a href="{{ route('reseller.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Daftarkan Reseller</button>
            </div>
        </form>
    </div>
</div>

{{-- PERBAIKAN STYLING TAMBAHAN DI BLADE AGAR MENGIKUTI ATURAN SIKU INDUK --}}
<style>
    .form-card,
    .form-group input,
    .form-group select,
    .btn-cancel,
    .btn-submit {
        border-radius: 0px !important;
    }
</style>
@endsection