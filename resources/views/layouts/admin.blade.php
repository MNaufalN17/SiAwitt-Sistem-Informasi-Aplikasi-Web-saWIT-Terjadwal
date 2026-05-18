<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAwitt - @yield('title')</title>
    <!-- Menggunakan Bootstrap 5 via CDN agar cepat dan ringan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar / Menu Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🌴 SiAwitt</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
           <li class="nav-item">
             <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
         </li>
             <li class="nav-item">
             <a class="nav-link {{ request()->routeIs('blok-kebun.*') ? 'active' : '' }}" href="{{ route('blok-kebun.index') }}">Data Blok</a>
          </li>
             <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pekerja.*') ? 'active' : '' }}" href="{{ route('pekerja.index') }}">Data Pekerja</a>
          </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('jadwal-kegiatan.*') ? 'active' : '' }}" href="{{ route('jadwal-kegiatan.index') }}">Jadwal & Verifikasi</a>
    </li>
</ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Area Konten Utama -->
    <div class="container mt-4 mb-5">
        @yield('content')
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>