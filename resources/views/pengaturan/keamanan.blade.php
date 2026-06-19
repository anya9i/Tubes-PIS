@extends('layouts.app')

@section('content')

<div class="security-container">

    <h2 class="security-title">Kata Sandi & Keamanan</h2>

    <div class="security-card">

        {{-- HEADER ROW - klik untuk expand --}}
        <div class="security-header" onclick="togglePasswordForm()">
            <div class="header-left">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Ubah Kata Sandi</span>
            </div>
            <i id="arrowIcon" class="fa-solid fa-chevron-right"></i>
        </div>

        {{-- FORM - muncul saat di klik --}}
        <div id="passwordForm" class="password-content">

            {{-- Kata Sandi Saat Ini --}}
            <div class="field-group">
                <label>Kata Sandi Saat Ini <span class="hint">(Terakhir Diperbarui 12/12/2025)</span></label>
                <div class="input-wrapper">
                    <input type="password"
                           id="currentPassword"
                           class="field-input"
                           placeholder="Masukkan Kata Sandi Saat Ini">
                    <i class="fa-solid fa-eye toggle-eye" onclick="toggleVisibility('currentPassword', this)"></i>
                </div>
            </div>

            {{-- Kata Sandi Baru --}}
            <div class="field-group">
                <label>Kata Sandi Baru</label>
                <div class="input-wrapper">
                    <input type="password"
                           id="newPassword"
                           class="field-input"
                           placeholder="Masukkan Kata Sandi Baru">
                    <i class="fa-solid fa-eye toggle-eye" onclick="toggleVisibility('newPassword', this)"></i>
                </div>
            </div>

            {{-- Verifikasi Sandi Baru --}}
            <div class="field-group">
                <label>Verifikasi Sandi Baru</label>
                <div class="input-wrapper">
                    <input type="password"
                           id="confirmPassword"
                           class="field-input"
                           placeholder="Tulis Ulang Kata Sandi Baru">
                    <i class="fa-solid fa-eye toggle-eye" onclick="toggleVisibility('confirmPassword', this)"></i>
                </div>
                <a href="#" class="lupa-sandi">Lupa Kata Sandi?</a>
            </div>

            {{-- Tombol Simpan --}}
            <div class="btn-row">
                <button class="btn-ubah">Ubah Kata Sandi</button>
            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>

.security-container {
    width: 700px;
    margin: auto;
}

.security-title {
    text-align: center;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 20px;
    color: #1a1a1a;
}

.security-card {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Header baris "Ubah Kata Sandi" */
.security-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    cursor: pointer;
    user-select: none;
    transition: background 0.2s;
}

.security-header:hover {
    background: #fafafa;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    font-weight: 600;
    color: #333;
}

.header-left i {
    color: #555;
    font-size: 15px;
}

#arrowIcon {
    font-size: 13px;
    color: #888;
    transition: transform 0.3s ease;
}

#arrowIcon.rotate {
    transform: rotate(90deg);
}

/* Form area */
.password-content {
    display: none;
    border-top: 1px solid #eee;
    padding: 22px 20px 20px;
}

.password-content.show {
    display: block;
}

/* Field group */
.field-group {
    margin-bottom: 16px;
}

.field-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.hint {
    font-weight: 400;
    color: #999;
    font-size: 11px;
}

/* Input wrapper dengan icon mata */
.input-wrapper {
    position: relative;
}

.field-input {
    width: 100%;
    height: 38px;
    border: 1px solid #e53935;
    padding: 0 38px 0 12px;
    font-size: 13px;
    font-family: 'Montserrat', sans-serif;
    color: #333;
    outline: none;
    background: #fff;
    transition: border-color 0.2s;
}

.field-input:focus {
    border-color: #c62828;
    box-shadow: 0 0 0 2px rgba(229,57,53,0.1);
}

.field-input::placeholder {
    color: #bbb;
    font-size: 12px;
}

.toggle-eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    cursor: pointer;
    font-size: 13px;
    transition: color 0.2s;
}

.toggle-eye:hover {
    color: #555;
}

/* Lupa kata sandi */
.lupa-sandi {
    display: inline-block;
    margin-top: 6px;
    font-size: 11px;
    color: #555;
    text-decoration: none;
}

.lupa-sandi:hover {
    color: #e53935;
    text-decoration: underline;
}

/* Tombol */
.btn-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 6px;
}

.btn-ubah {
    background: #1565c0;
    color: white;
    border: none;
    padding: 9px 22px;
    font-size: 12px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    cursor: pointer;
    transition: background 0.2s;
    letter-spacing: 0.3px;
}

.btn-ubah:hover {
    background: #0d47a1;
}

</style>
@endpush

@push('scripts')
<script>

function togglePasswordForm() {
    document.getElementById('passwordForm').classList.toggle('show');
    document.getElementById('arrowIcon').classList.toggle('rotate');
}

function toggleVisibility(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

</script>
@endpush