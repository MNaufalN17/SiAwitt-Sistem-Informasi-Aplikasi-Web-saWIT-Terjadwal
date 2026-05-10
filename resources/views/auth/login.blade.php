<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SiAwitt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Tema Hijau Modern (Bisa diganti dengan URL gambar kebun sawit) */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a2e16 0%, #14532d 50%, #16a34a 100%);
            /* Jika ada gambar lokal, hilangkan comment di bawah ini: */
            /* background-image: url('URL_GAMBAR_SAWIT'), linear-gradient(135deg, #0a2e16, #16a34a); */
            /* background-blend-mode: overlay; */
            /* background-size: cover; */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        /* Ornamen Lingkaran untuk memperkuat efek Glassmorphism */
        .circle-1, .circle-2 {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }
        .circle-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #4ade80, #22c55e);
            top: -50px;
            left: -50px;
            filter: blur(40px);
            opacity: 0.6;
        }
        .circle-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #bbf7d0, #16a34a);
            bottom: -80px;
            right: -50px;
            filter: blur(50px);
            opacity: 0.5;
        }

        /* Glassmorphism Card Utama */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            z-index: 1;
            color: #ffffff;
        }

        .glass-card h2 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .glass-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        /* Kustomisasi Input Form */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
            padding: 12px 15px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #4ade80;
            box-shadow: 0 0 0 0.25rem rgba(74, 222, 128, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Kustomisasi Checkbox */
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .form-check-input:checked {
            background-color: #22c55e;
            border-color: #22c55e;
        }

        /* Tombol Login */
        .btn-glass {
            background: linear-gradient(90deg, #16a34a, #22c55e);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: linear-gradient(90deg, #15803d, #16a34a);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(22, 163, 74, 0.4);
        }

        .invalid-feedback {
            color: #fca5a5;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Ornamen Latar Belakang -->
    <div class="circle-1"></div>
    <div class="circle-2"></div>

    <!-- Kotak Login -->
    <div class="glass-card">
        <div class="text-center">
            <h2>🌴 SiAwitt</h2>
            <p>Sistem Informasi Agenda Waktu sawIT</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email terdaftar">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-light" for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-glass w-100">
                MASUK KE SISTEM
            </button>
        </form>
    </div>

</body>
</html>