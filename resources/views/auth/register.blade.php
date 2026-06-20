<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Brasil Stock Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }
        
        .register-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* SISI KIRI: FORMAT BACKGROUND IMAGE PERSIS SEPERTI LOGIN */
        .register-image {
            flex: 1.0; 
            background: url('{{ asset("images/log.png") }}');
            background-size: 100%; /* Mengisi seluruh area layar kiri secara proporsional */
            background-repeat: no-repeat;
            background-position: center;
            background-color: #ffffff; 
            position: relative;
            display: none;
        }

        /* Overlay halus di atas gambar */
        .register-image::before {
            content: '';
            position: absolute;
            inset: 5 px; /* Sedikit lebih kecil dari area gambar untuk efek bingkai */
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        @media (min-width: 992px) {
            .register-image { display: block; }
        }

        /* SISI KANAN: FORM SECTION */
        .right-side {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #F0F2F5; /* Mengikuti tingkat abu-abu UI */
            position: relative;
            z-index: 2;
        }
        
        .form-container {
            width: 100%;
            max-width: 450px;
        }
        
        .brand-logo {
            position: absolute;
            top: 30px;
            right: 40px;
            width: 120px;
        }
        
        .ui-title {
            font-size: 36px;
            font-weight: 600; /* Montserrat 36 SemiBold */
            color: #333333;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-label {
            font-weight: 700;
            font-size: 13px;
            color: #555555;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        
        .form-control-custom {
            border-radius: 12px;
            border: 1.5px solid #dc3545; /* Border merah branding Brasil */
            padding: 12px 15px;
            font-size: 14px;
            background-color: #FFFFFF !important;
            color: #000000 !important;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        
        .form-control-custom::placeholder {
            color: #BDBDBD !important;
            text-transform: uppercase;
            font-size: 12px;
        }
        
        .form-control-custom:focus {
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.2);
            border-color: #b02a37;
            outline: none;
        }
        
        .btn-registrasi {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 10px;
            padding: 12px 40px;
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
            transition: transform 0.2s;
        }
        
        .btn-registrasi:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0056b3, #004494);
        }
        
        .invalid-feedback {
            font-weight: 500;
            font-size: 12px;
        }
        
        .footer-links {
            margin-top: 25px;
            width: 100%;
        }
        
        .footer-links a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 700;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-image"></div>

    <div class="right-side">
        {{-- Logo Brasil Merah --}}
        <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" class="brand-logo">
        
        <div class="form-container">
            <h1 class="ui-title">Registrasi Akun</h1>

            <form action="/register" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           class="form-control form-control-custom @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="Masukkan Email" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Format email tidak valid (Contoh: nama@gmail.com).</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">Nama Depan</label>
                    <input type="text" 
                           class="form-control form-control-custom @error('first_name') is-invalid @enderror" 
                           id="first_name" 
                           name="first_name" 
                           value="{{ old('first_name') }}"
                           placeholder="Masukkan Nama Depan" 
                           pattern="^[a-zA-Z\s]+$" 
                           required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Nama depan hanya boleh berisi huruf dan spasi (tanpa angka/karakter unik).</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Nama Belakang</label>
                    <input type="text" 
                           class="form-control form-control-custom @error('last_name') is-invalid @enderror" 
                           id="last_name" 
                           name="last_name" 
                           value="{{ old('last_name') }}"
                           placeholder="Masukkan Nama Belakang" 
                           pattern="^[a-zA-Z\s]+$" 
                           required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Nama belakang hanya boleh berisi huruf dan spasi (tanpa angka/karakter unik).</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" 
                           class="form-control form-control-custom @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Buat Kata Sandi" 
                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Kata sandi harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter spesial (@$!%*?&).</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Ulang Kata Sandi</label>
                    <input type="password" 
                           class="form-control form-control-custom" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Konfirmasi Ulang Kata Sandi" 
                           required>
                    <div class="invalid-feedback" id="confirm-feedback">Konfirmasi kata sandi wajib diisi.</div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-registrasi shadow-sm">Registrasi</button>
                </div>
            </form>

            <div class="footer-links text-center">
                <p class="text-muted small">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('password_confirmation');
                const confirmFeedback = document.getElementById('confirm-feedback');

                // Validasi kecocokan konfirmasi kata sandi secara realtime
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Password tidak cocok');
                    confirmFeedback.textContent = 'Konfirmasi kata sandi tidak cocok dengan kata sandi di atas!';
                } else {
                    confirmPassword.setCustomValidity('');
                }

                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>
</html>