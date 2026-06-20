@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="profile-viewport-wrapper" style="font-family: 'Montserrat', sans-serif; padding: 20px 10px; box-sizing: border-box;">

    <div class="mb-4" style="max-width: 900px; margin: 0 auto 20px auto;">
        <a href="{{ route('pengaturan.index') }}" class="btn-back-trigger">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Pengaturan
        </a>
    </div>

    <!-- NOTIFIKASI SUKSES MENYIMPAN -->
    @if(session('success'))
        <div class="alert alert-success border-0 mb-4" style="border-radius: 0px; max-width: 900px; margin: 0 auto 20px auto; background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; font-weight: 600;">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="brasil-profile-card">
        
        {{-- ================= HEADER PROFIL ================= --}}
        <div class="profile-card-header">
            <div class="profile-header-left">
                <img src="{{ asset('images/avatar.jpeg') }}" class="profile-avatar-rect" alt="Avatar User">
                <div class="profile-title-stack">
                    <h4 class="profile-display-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}</h4>
                    <span class="profile-display-role">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>
            <button id="editBtn" class="btn-action-edit">EDIT</button>
        </div>

        {{-- ================= FORM ISIAN DATA USER ================= --}}
        {{-- PERBAIKAN: Mengarahkan action ke route update dan mengubah id form --}}
        <form id="profileFormAction" action="{{ route('pengaturan.profil.update') }}" method="POST" class="profile-card-body">
            @csrf
            <div class="form-grid-layout">

                {{-- PERBAIKAN: Menambahkan atribut name="..." pada setiap input agar bisa ditangkap database --}}
                <div class="form-input-group">
                    <label class="form-input-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" class="form-input-control" readonly required>
                </div>

                <div class="form-input-group">
                    <label class="form-input-label">Username</label>
                    <input type="text" name="username" value="{{ auth()->user()->username }}" class="form-input-control" readonly required>
                </div>

                <div class="form-input-group" style="grid-column: span 2;">
                    <label class="form-input-label">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-input-control" readonly required>
                </div>

                {{-- HANYA MUNCUL JIKA USER YANG LOGIN ADALAH RESELLER --}}
                @if(auth()->user()->role === 'reseller')
                    <div class="form-input-group">
                        <label class="form-input-label">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ auth()->user()->no_telepon }}" class="form-input-control" readonly>
                    </div>

                    <div class="form-input-group">
                        <label class="form-input-label">Wilayah</label>
                        <input type="text" name="wilayah" value="{{ auth()->user()->wilayah }}" class="form-input-control" readonly>
                    </div>

                    <div class="form-input-group" style="grid-column: span 2;">
                        <label class="form-input-label">Alamat Domisili</label>
                        <input type="text" name="alamat" value="{{ auth()->user()->alamat }}" class="form-input-control" readonly>
                    </div>
                @endif

            </div>

            <div class="text-end mt-4">
                <button type="submit" id="saveBtn" class="btn-action-save hidden-element">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>

    </div>
</div>

{{-- ================= SCRIPT INTERAKTIF JAVASCRIPT MURNI ================= --}}
<script>
    document.getElementById('editBtn').addEventListener('click', function(e) {
        e.preventDefault();
        // Memperbaiki selector agar membaca id form yang baru
        const inputs = document.querySelectorAll('#profileFormAction .form-input-control');
        const saveBtn = document.getElementById('saveBtn');
        
        if (inputs[0].hasAttribute('readonly')) {
            // AKTIFKAN MODE EDIT
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                input.classList.add('edit-mode-active');
            });
            this.innerText = 'BATAL';
            this.style.backgroundColor = '#6c757d';
            saveBtn.classList.remove('hidden-element');
        } else {
            // KEMBALI KE MODE READONLY
            inputs.forEach(input => {
                input.setAttribute('readonly', 'readonly');
                input.classList.remove('edit-mode-active');
            });
            this.innerText = 'EDIT';
            this.style.backgroundColor = '#ff0000';
            saveBtn.classList.add('hidden-element');
        }
    });
</script>

{{-- ================= STYLING ENGINE (MURNI NO-ROUNDED RECTANGLE STYLE) ================= --}}
<style>
    /* Reset Sudut Menjadi Siku-Siku Sesuai Aturan Utama Proyek Induk */
    .brasil-profile-card, 
    .profile-avatar-rect, 
    .form-input-control, 
    .btn-action-edit, 
    .btn-action-save,
    .btn-back-trigger {
        border-radius: 0px !important;
    }

    .btn-back-trigger {
        display: inline-block;
        background: #ffffff;
        color: #111111;
        font-weight: 700;
        text-decoration: none;
        padding: 10px 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        font-size: 14px;
        transition: all 0.2s;
    }
    .btn-back-trigger:hover {
        background: #f9fafb;
        color: #ff0000;
    }

    .brasil-profile-card {
        background: #ffffff;
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        box-shadow: 0 4px 25 rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .profile-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 30px 40px;
        border-bottom: 1px solid #f3f4f6;
        background: #ffffff;
    }
    .profile-header-left {
        display: flex;
        align-items: center;
    }
    .profile-avatar-rect {
        width: 75px;
        height: 75px;
        object-fit: cover;
        margin-right: 20px;
        border: 1px solid #d1d5db;
    }
    .profile-display-name {
        font-size: 22px;
        font-weight: 700;
        color: #111111;
        margin: 0 0 4px 0;
    }
    .profile-display-role {
        font-size: 15px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-action-edit {
        background-color: #ff0000;
        color: #ffffff;
        border: none;
        font-weight: 700;
        padding: 10px 30px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-action-edit:hover {
        background-color: #cc0000;
    }

    .profile-card-body {
        padding: 40px;
        background: #ffffff;
    }
    .form-grid-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .form-input-group {
        display: flex;
        flex-direction: column;
    }
    .form-input-label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input-control {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 15px;
        color: #1f2937;
        font-weight: 600;
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }
    
    .form-input-control.edit-mode-active {
        background-color: #ffffff !important;
        border: 1px solid #ff0000 !important;
        color: #000000;
    }

    .btn-action-save {
        background-color: #111111;
        color: #ffffff;
        border: none;
        font-weight: 700;
        padding: 14px 40px;
        font-size: 14px;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-action-save:hover {
        background-color: #333333;
    }

    .hidden-element {
        display: none !important;
    }

    @media (max-width: 768px) {
        .form-grid-layout {
            grid-template-columns: 1fr;
        }
        .profile-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        .btn-action-edit {
            width: 100%;
        }
        .form-input-group {
            grid-column: span 1 !important;
        }
    }
</style>
@endsection