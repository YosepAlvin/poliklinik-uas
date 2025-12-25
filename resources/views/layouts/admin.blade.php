<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}" href="{{ route('admin.dokter.index') }}">Dokter</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.poli.*') ? 'active' : '' }}" href="{{ route('admin.poli.index') }}">Poli</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}" href="{{ route('admin.pasien.index') }}">Pasien</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active' : '' }}" href="{{ route('admin.obat.index') }}">Obat</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.resep.*') ? 'active' : '' }}" href="{{ route('admin.resep.index') }}">Laporan</a></li>
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
                    <li class="nav-item"><span class="px-3 text-muted">Admin</span></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dokter.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.dokter.index') }}">
                            <i class="bi bi-person-badge"></i> Kelola Dokter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.poli.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.poli.index') }}">
                            <i class="bi bi-collection"></i> Kelola Poli
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pasien.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.pasien.index') }}">
                            <i class="bi bi-people"></i> Kelola Pasien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.obat.index') }}">
                            <i class="bi bi-capsule"></i> Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.jadwal.index') }}">
                            <i class="bi bi-calendar3"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.resep.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.resep.index') }}">
                            <i class="bi bi-file-earmark-text"></i> Laporan
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
