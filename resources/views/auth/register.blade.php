<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Brasil Stock Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #F8F9FA;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .left-side {
            background-color: #2B3437; /* Warna gelap background gambar sebelah kiri */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0;
        }
        .left-side img {
            width: 100%;
            height: 50vh;
            object-fit: cover;
        }
        .right-side {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #F0F2F5; /* Menyesuaikan keabuan di UI gambar */
        }
        .form-container {
            width: 100%;
            max-width: 500px;
        }
        .brand-logo {
            text-align: right;
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
        }
        .brand-logo img {
            max-width: 150px;
        }
        .ui-title {
            font-size: 36px;
            font-weight: 600; /* SemiBold */
            color: #4A4A4A;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-label {
            font-weight: 700;
            font-size: 14px;
            color: #000000;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .form-control {
            border: 1.5px solid #D65A5A; /* Border kemerahan halus seperti di UI */
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 14px;
            background-color: #FFFFFF;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        .form-control::placeholder {
            color: #BDBDBD;
            text-transform: uppercase;
            font-size: 13px;
        }
        .form-control:focus {
            border-color: #B83939;
            box-shadow: 0 0 0 0.25rem rgba(214, 90, 90, 0.25);
            outline: none;
        }
        .btn-registrasi {
            background-color: #0066CC; /* Biru cerah sesuai UI */
            color: #FFFFFF;
            font-weight: 600;
            padding: 10px 50px;
            border-radius: 15px;
            border: 1px solid #0052A3;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }
        .btn-registrasi:hover {
            background-color: #0052A3;
            color: #FFFFFF;
            transform: translateY(-1px);
        }
        .invalid-feedback {
            font-weight: 500;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-6 d-none d-md-flex left-side">
            <img src="{{ asset('storage/foto_brasil_atas.jpg') }}" alt="Es Brasil Batang">
            <img src="{{ asset('storage/foto_brasil_bawah.jpg') }}" alt="Es Brasil Pack">
        </div>

        <div class="col-md-6 right-side">
            
            <div class="brand-logo">
                <img src="{{ asset('storage/logo_brasil.png') }}" alt="Logo Brasil Es Krim & Kopi">
            </div>

            <div class="form-container">
                <h1 class="ui-title">Registrasi Akun</h1>

                <form action="/register" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
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
                               class="form-control @error('first_name') is-invalid @enderror" 
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
                               class="form-control @error('last_name') is-invalid @enderror" 
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
                               class="form-control @error('password') is-invalid @enderror" 
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
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi Ulang Kata Sandi" 
                               required>
                        <div class="invalid-feedback" id="confirm-feedback">Konfirmasi kata sandi wajib diisi.</div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-registrasi">Registrasi</button>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-bold">Login</a></small>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('password_confirmation');
                const confirmFeedback = document.getElementById('confirm-feedback');

                // Validasi Kecocokan Password secara Realtime di Frontend
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