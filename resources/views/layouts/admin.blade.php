<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SiAwitt - Sistem Informasi')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        /* CSS khusus untuk menyembunyikan navbar & tombol saat print laporan */
        @media print {
            nav, .navbar, .btn {
                display: none !important;
            }
            body {
                background-color: white !important;
            }
            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
        
        /* Tema Hijau Perkebunan untuk Navbar */
        .navbar-custom {
            background-color: #2e7d32; /* Hijau Tua */
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link {
            color: #ffffff;
        }
        .navbar-custom .nav-link:hover {
            color: #dcedc8;
        }
        .navbar-custom .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #ffffff;
        }
    </style>
</head>
<body class="bg-light">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    🌴 SiAwitt
                </a>
                
                <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        @if(auth()->check() && auth()->user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('jadwal-kegiatan.*') ? 'active' : '' }}" href="{{ route('jadwal-kegiatan.index') }}">Monitoring Progres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">Laporan Akhir</a>
                            </li>
                        @endif

                        @if(auth()->check() && auth()->user()->role == 'mandor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('blok-kebun.*') ? 'active' : '' }}" href="{{ route('blok-kebun.index') }}">Kelola Blok</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pekerja.*') ? 'active' : '' }}" href="{{ route('pekerja.index') }}">Kelola Pekerja</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('jadwal-kegiatan.*') ? 'active' : '' }}" href="{{ route('jadwal-kegiatan.index') }}">Manajemen Jadwal</a>
                            </li>
                        @endif
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Halo, {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        🚪 {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
</body>
</html>