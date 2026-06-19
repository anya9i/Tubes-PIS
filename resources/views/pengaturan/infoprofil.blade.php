@extends('layouts.app')

@section('content')
<!-- Memanggil Font Montserrat & Font Awesome untuk Keperluan Ikon Form -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- CONTAINER UTAMA (Melayang Simetris di atas Background Ruko) -->
<div class="profile-viewport-wrapper" style="
    font-family: 'Montserrat', sans-serif;
    padding: 20px 10px;
    box-sizing: border-box;">

    <!-- Tombol Kembali ke Halaman Pengaturan Utama -->
    <div class="mb-4" style="max-width: 900px; margin: 0 auto 20px auto;">
        <a href="{{ route('pengaturan.index') }}" class="btn-back-trigger">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Pengaturan
        </a>
    </div>

    <!-- KARTU UTAMA PROFIL -->
    <div class="brasil-profile-card">
        
        {{-- ================= HEADER PROFIL ================= --}}
        <div class="profile-card-header">
            <div class="profile-header-left">
                <!-- Foto Avatar Dikecilkan Secara Proporsional & Berbentuk Kotak Tanpa Rounded Sesuai Tema Utama Layout -->
                <img src="{{ asset('images/avatar.jpeg') }}" class="profile-avatar-rect" alt="Avatar Admin">
                <div class="profile-title-stack">
                    <h4 class="profile-display-name">Adalah Pokoknya</h4>
                    <span class="profile-display-role">Owner</span>
                </div>
            </div>
            <!-- Tombol Kelola Mode Edit -->
            <button id="editBtn" class="btn-action-edit">EDIT</button>
        </div>

        {{-- ================= FORM ISIAN DATA USER ================= --}}
        <form id="profileForm" class="profile-card-body">
            @csrf
            <div class="form-grid-layout">

                <!-- 1. Nama Depan -->
                <div class="form-input-group">
                    <label class="form-input-label">Nama Depan</label>
                    <input type="text" value="Fakhri" class="form-input-control" readonly>
                </div>

                <!-- 2. Nama Belakang -->
                <div class="form-input-group">
                    <label class="form-input-label">Nama Belakang</label>
                    <input type="text" value="Pangeran Beji" class="form-input-control" readonly>
                </div>

                <!-- 3. Email -->
                <div class="form-input-group">
                    <label class="form-input-label">Email</label>
                    <input type="email" value="owner@gmail.com" class="form-input-control" readonly>
                </div>

                <!-- 4. Alamat -->
                <div class="form-input-group">
                    <label class="form-input-label">Alamat</label>
                    <input type="text" value="Purwokerto, Banyumas" class="form-input-control" readonly>
                </div>

                <!-- 5. No. Telepon -->
                <div class="form-input-group">
                    <label class="form-input-label">No. Telepon</label>
                    <input type="text" value="+62 838 7777 8000" class="form-input-control" readonly>
                </div>

                <!-- 6. Wilayah -->
                <div class="form-input-group">
                    <label class="form-input-label">Wilayah</label>
                    <input type="text" value="Jawa Tengah" class="form-input-control" readonly>
                </div>

            </div>

            <!-- Tombol Simpan (Disembunyikan Secara Default, Muncul Saat Tombol Edit Diklik) -->
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
        const inputs = document.querySelectorAll('#profileForm .form-input-control');
        const saveBtn = document.getElementById('saveBtn');
        
        // Periksa apakah sedang dalam mode Readonly
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

    // Simulasi Pengiriman Data Form
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Sukses! Data perubahan profil berhasil disimpan ke sistem.');
        window.location.reload();
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

    /* Tombol Kembali Style */
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

    /* Struktur Card Utama */
    .brasil-profile-card {
        background: #ffffff;
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    /* Bagian Atas Card (Header Profil) */
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

    /* Tombol Aksi */
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

    /* Form Body & Grid Kontrol */
    .profile-card-body {
        padding: 40px;
        background: #ffffff;
    }
    .form-grid-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    /* Input Element */
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
    
    /* State Khusus Ketika Input Aktif Di-Edit */
    .form-input-control.edit-mode-active {
        background-color: #ffffff !important;
        border: 1px solid #ff0000 !important;
        color: #000000;
    }

    /* Tombol Simpan */
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

    /* Helper Element */
    .hidden-element {
        display: none !important;
    }

    /* Responsive untuk Layar HP */
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
    }
</style>
@endsection