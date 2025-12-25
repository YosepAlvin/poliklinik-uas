<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dokter - Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dokter</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}" href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter.periksa.*') ? 'active' : '' }}" href="{{ route('dokter.periksa.index') }}">Periksa</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter.riwayat.*') ? 'active' : '' }}" href="{{ route('dokter.riwayat.index') }}">Riwayat</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter.jadwal.*') ? 'active' : '' }}" href="{{ route('dokter.jadwal.index') }}">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter.resep.*') ? 'active' : '' }}" href="{{ route('dokter.resep.index') }}">Resep</a></li>
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
                    <li class="nav-item"><span class="px-3 text-muted">Dokter</span></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dokter.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.periksa.*') ? 'active fw-bold' : '' }}" href="{{ route('dokter.periksa.index') }}">
                            <i class="bi bi-clipboard2-pulse"></i> Periksa Pasien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.riwayat.*') ? 'active fw-bold' : '' }}" href="{{ route('dokter.riwayat.index') }}">
                            <i class="bi bi-clock-history"></i> Riwayat Pasien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.jadwal.*') ? 'active fw-bold' : '' }}" href="{{ route('dokter.jadwal.index') }}">
                            <i class="bi bi-calendar-check"></i> Jadwal Periksa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.resep.*') ? 'active fw-bold' : '' }}" href="{{ route('dokter.resep.index') }}">
                            <i class="bi bi-prescription"></i> Resep
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
