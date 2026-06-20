<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode OTP - Brasil Stock Management</title>
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
            background-color: #F0F2F5;
        }
        
        .register-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* SISI KIRI: FORMAT BACKGROUND IMAGE DARI TOKO PERSIS SEPERTI LOGIN */
        .register-image {
            flex: 1.0; 
            background: url('{{ asset("images/log.png") }}');
            background-size: cover; /* Mengisi penuh area kiri secara proporsional */
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
            inset: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        @media (min-width: 992px) {
            .register-image { display: block; }
        }

        /* SISI KANAN: FORM SECTION VERIFIKASI */
        .right-side {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start; /* Posisi rata kiri sesuai dengan gambar acuan */
            padding: 80px;
            background-color: #F0F2F5; 
            position: relative;
            z-index: 2;
        }
        
        .form-container {
            width: 100%;
            max-width: 450px;
        }
        
        .brand-logo {
            position: absolute;
            top: 40px;
            right: 50px;
            width: 130px;
            height: auto;
        }
        
        /* Judul Menu Utama */
        .ui-title {
            font-size: 32px;
            font-weight: 600; /* Montserrat SemiBold */
            color: #000000;
            text-align: left;
            margin-bottom: 25px;
        }
        
        /* Label Judul Section Form */
        .verification-label {
            font-size: 18px;
            font-weight: 500;
            color: #000000;
            margin-bottom: 20px;
            text-align: left;
        }
        
        /* GROUP KOTAK INPUT OTP DINAMIS */
        .otp-input-group {
            display: flex;
            justify-content: flex-start;
            gap: 15px; /* Jarak antar kotak box */
            margin-bottom: 35px;
            width: 100%;
        }
        
        /* Format Kotak Angka Sesuai Gambar Referensi */
        .otp-box {
            width: 60px;
            height: 65px;
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            border: 1.5px solid #dc3545; /* Border merah serasi dengan branding Brasil */
            border-radius: 12px;
            background-color: #FFFFFF !important;
            color: #000000 !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .otp-box:focus {
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.3);
            border-color: #b02a37;
            outline: none;
        }
        
        /* Tombol Aksi Utama (Continue) */
        .btn-continue {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: 1px solid #0056b3;
            border-radius: 14px;
            padding: 10px 60px; /* Lebar padding tombol proporsional seperti di UI */
            font-size: 16px;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
            transition: all 0.2s ease;
            display: block;
            margin: 0 auto; /* Menjaga posisi tombol terpusat di bawah box */
        }
        
        .btn-continue:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #0056b3, #004494);
            color: white;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-image"></div>

    <div class="right-side">
        <img src="{{ asset('images/LogoBrasilMerah.png') }}" alt="Logo Brasil" class="brand-logo">
        
        <div class="form-container">
            <h1 class="ui-title">Register</h1>
            
            <div class="verification-label">Verifikasi Kode</div>

            <form action="/verify-otp" method="POST" class="needs-validation" novalidate>
                @csrf
                
                <div class="otp-input-group">
                    <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autocomplete="off" placeholder="0">
                    <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autocomplete="off">
                    <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autocomplete="off">
                    <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autocomplete="off">
                    <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autocomplete="off">
                </div>

                <button type="submit" class="btn btn-continue shadow-sm">Continue</button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll('.otp-box');
        
        inputs.forEach((input, index) => {
            // Pindah fokus secara otomatis ke kotak kanan ketika user mengetik angka
            input.addEventListener('input', function() {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Mundur ke kotak kiri otomatis apabila menekan tombol backspace pada keyboard
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
</body>
</html>