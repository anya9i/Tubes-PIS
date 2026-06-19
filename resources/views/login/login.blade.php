<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Es & Kopi Brasil | Login</title>

    {{-- Fonts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    
    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- AdminLTE (Jika masih dibutuhkan untuk komponen lain) --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans 3', sans-serif;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* SISI KIRI: BACKGROUND IMAGE DARI TOKO */
        .login-image {
            flex: 1.0; /* Mengecilkan lebar kolom gambar */
            background: url('{{ asset("images/log.png") }}');
            background-size: 100%; /* Mengecilkan ukuran gambar di dalam kolom */
            background-repeat: no-repeat;
            background-position: center;
            background-color: #ffffff; /* Tambahkan warna latar jika gambar tidak memenuhi kotak */
            position: relative;
            display: none;
        }

        /* Overlay blur tipis agar senada dengan referensi sidebar */
        .login-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        @media (min-width: 992px) {
            .login-image { display: block; }
        }

        /* SISI KANAN: FORM SECTION */
        .login-form-section {
            flex: 1;
            background: #F0F0EE;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 40px;
            z-index: 2;
        }

        /* Logo Brasil di Pojok Kanan Atas */
        .brand-logo {
            position: absolute;
            top: 30px;
            right: 40px;
            width: 120px;
        }

        .login-card-custom {
            width: 100%;
            max-width: 380px;
        }

        .login-title {
            font-weight: 800;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        /* Input dengan style border merah sesuai branding Brasil */
        .form-control-custom {
            border-radius: 12px;
            border: 1.5px solid #dc3545; 
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.2);
            border-color: #b02a37;
        }

        /* Tombol Biru Glossy */
        .btn-login {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 10px;
            padding: 12px 40px;
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
            float: right;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0056b3, #004494);
        }

        .footer-links {
            margin-top: 60px;
            color: #777;
        }

        .footer-links a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="login-container">
        {{-- Bagian Kiri: Visual Produk/Toko --}}
        <div class="login-image"></div>

        {{-- Bagian Kanan: Area Form --}}
        <div class="login-form-section">
            {{-- Logo Brasil Merah --}}
            <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" class="brand-logo">

            <div class="login-card-custom">
                <h1 class="login-title">Login</h1>

                @if (session('failed'))
                    {{-- FIX: Perbaikan class 'alert alert-danger' agar muncul warna merah --}}
                    <div class="alert alert-danger">{{ session('failed') }}</div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    {{-- FIX: Penambahan @csrf untuk keamanan dan mencegah error 419 --}}
                    @csrf
                    
                    {{-- Input Email --}}
            <div class="mb-4">
                <label class="form-label">
                    <i class="fa-solid fa-envelope me-2"></i>Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control form-control-custom @error('email') is-invalid @enderror"
                    placeholder="admin@gmail.com" required>
                
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Password --}}
            <div class="mb-2">
                <label class="form-label">
                    <i class="fa-solid fa-lock me-2"></i>Kata Sandi
                </label>
                <input type="password" name="password" 
                    class="form-control form-control-custom @error('password') is-invalid @enderror"
                    placeholder="********" required>
                
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

                    <div class="mb-4">
                        <a href="#" class="text-muted small text-decoration-none">Lupa Kata Sandi?</a>
                    </div>

                    {{-- Tombol Login --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-login shadow-sm">
                            LOGIN <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="footer-links text-center">
                    Belum punya akun? <a href="#">Daftar</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>