<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pasien - Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Pasien</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}" href="{{ route('pasien.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.periksa.*') ? 'active' : '' }}" href="{{ route('pasien.periksa.index') }}">Periksa</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.riwayat.*') ? 'active' : '' }}" href="{{ route('pasien.riwayat.index') }}">Riwayat</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.resep.*') ? 'active' : '' }}" href="{{ route('pasien.resep.index') }}">Resep</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.pendaftaran.*') ? 'active' : '' }}" href="{{ route('pasien.pendaftaran.index') }}">Jadwal</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="ms-2">@csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse show border-end">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><span class="px-3 text-muted">Pasien</span></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('pasien.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.periksa.*') ? 'active fw-bold' : '' }}" href="{{ route('pasien.periksa.index') }}">
                            <i class="bi bi-clipboard2-pulse"></i> Periksa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.riwayat.*') ? 'active fw-bold' : '' }}" href="{{ route('pasien.riwayat.index') }}">
                            <i class="bi bi-clock-history"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.resep.*') ? 'active fw-bold' : '' }}" href="{{ route('pasien.resep.index') }}">
                            <i class="bi bi-prescription"></i> Resep
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.pendaftaran.*') ? 'active fw-bold' : '' }}" href="{{ route('pasien.pendaftaran.index') }}">
                            <i class="bi bi-calendar-check"></i> Jadwal
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
