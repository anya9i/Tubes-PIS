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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="border-radius: 0px; max-width: 900px; margin: 0 auto 20px auto; background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; font-weight: 600;">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <button id="editBtn" class="btn-action-edit">PERBARUI</button>
        </div>

        {{-- ================= FORM ISIAN DATA USER ================= --}}
        <form id="profileFormAction" action="{{ route('pengaturan.profil.update') }}" method="POST" class="profile-card-body">
            @csrf
            <div class="form-grid-layout">

                <div class="form-input-group">
                    <label class="form-input-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" class="form-input-control" readonly required data-placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-input-group">
                    <label class="form-input-label">Username</label>
                    <input type="text" 
                           name="username" 
                           value="{{ auth()->user()->username }}" 
                           class="form-input-control permanen-kunci" 
                           readonly 
                           required 
                           title="Hubungi admin untuk mengubah username" 
                           style="background-color: #f3f4f6; color: #9ca3af; cursor: not-allowed;">
                </div>

                <div class="form-input-group" style="grid-column: span 2;">
                    <label class="form-input-label">Email Terdaftar</label>
                    <input type="email" 
                           name="email" 
                           value="{{ auth()->user()->email }}" 
                           class="form-input-control permanen-kunci" 
                           readonly 
                           required 
                           title="Hubungi admin untuk mengubah email terdaftar" 
                           style="background-color: #f3f4f6; color: #9ca3af; cursor: not-allowed;">
                </div>

                {{-- HANYA MUNCUL JIKA USER YANG LOGIN ADALAH RESELLER --}}
                @if(auth()->user()->role === 'reseller')
                    
                    <div class="form-input-group">
                        <div class="label-helper-wrapper">
                            <label class="form-input-label">No. Telepon</label>
                            @if(empty(auth()->user()->no_telepon))
                                <span class="helper-text-alert"><i class="fa-solid fa-circle-exclamation"></i> Belum diisi</span>
                            @endif
                        </div>
                        <input type="text" name="no_telepon" value="{{ auth()->user()->no_telepon ?? '-' }}" class="form-input-control" readonly data-placeholder="Contoh: 08123456789">
                    </div>

                    <div class="form-input-group">
                        <div class="label-helper-wrapper">
                            <label class="form-input-label">Wilayah</label>
                            @if(empty(auth()->user()->wilayah))
                                <span class="helper-text-alert"><i class="fa-solid fa-circle-exclamation"></i> Belum diisi</span>
                            @endif
                        </div>
                        <input type="text" name="wilayah" value="{{ auth()->user()->wilayah ?? '-' }}" class="form-input-control" readonly data-placeholder="Contoh: Purwokerto Timur">
                    </div>

                    <div class="form-input-group" style="grid-column: span 2;">
                        <div class="label-helper-wrapper">
                            <label class="form-input-label">Alamat Domisili</label>
                            @if(empty(auth()->user()->alamat))
                                <span class="helper-text-alert"><i class="fa-solid fa-circle-exclamation"></i> Belum diisi</span>
                            @endif
                        </div>
                        <input type="text" name="alamat" value="{{ auth()->user()->alamat ?? '-' }}" class="form-input-control" readonly data-placeholder="Contoh: Jl. Jenderal Suprapto No. 25">
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
        
        const inputs = document.querySelectorAll('#profileFormAction .form-input-control:not(.permanen-kunci)');
        const helpers = document.querySelectorAll('.helper-text-alert');
        const saveBtn = document.getElementById('saveBtn');
        
        if (inputs[0].hasAttribute('readonly')) {
            // ================= AKTIFKAN MODE EDIT =================
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                input.classList.add('edit-mode-active');
                
                const targetPlaceholder = input.getAttribute('data-placeholder');
                if (targetPlaceholder) {
                    input.setAttribute('placeholder', targetPlaceholder);
                }

                if (input.value === '-') {
                    input.value = '';
                }
            });

            helpers.forEach(helper => {
                helper.style.display = 'none';
            });

            this.innerText = 'BATAL';
            this.style.backgroundColor = '#6c757d';
            saveBtn.classList.remove('hidden-element');

        } else {
            // ================= KEMBALI KE MODE READONLY =================
            inputs.forEach(input => {
                input.setAttribute('readonly', 'readonly');
                input.classList.remove('edit-mode-active');
                input.removeAttribute('placeholder');
                
                if (input.value.trim() === '') {
                    input.value = '-';
                }
            });

            inputs.forEach(input => {
                if (input.value === '-') {
                    const group = input.closest('.form-input-group');
                    const helper = group.querySelector('.helper-text-alert');
                    if (helper) {
                        helper.style.display = 'inline-block';
                    }
                }
            });

            this.innerText = 'PERBARUI';
            this.style.backgroundColor = '#ff0000';
            saveBtn.classList.add('hidden-element');
        }
    });
</script>

{{-- ================= STYLING ENGINE ================= --}}
<style>
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
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
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

    .label-helper-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .form-input-label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .helper-text-alert {
        font-size: 11px;
        font-weight: 700;
        color: #e02424;
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

    .form-input-control::placeholder {
        color: #9ca3af;
        font-weight: 400;
        opacity: 0.8;
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