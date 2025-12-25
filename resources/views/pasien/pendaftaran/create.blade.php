<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Pasien</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('pasien.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ url('/pasien/pendaftaran') }}"><i class="bi bi-calendar-check"></i> Pendaftaran</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/pasien/resep') }}"><i class="bi bi-prescription"></i> Resep</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="btn btn-outline-light btn-sm ms-2">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="container py-4">
    <h4 class="mb-3">Form Pendaftaran</h4>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div><strong>Poli:</strong> {{ $jadwal->poli->nama_poli ?? '-' }}</div>
                    <div><strong>Dokter:</strong> {{ $jadwal->dokter->name ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Hari:</strong> {{ $jadwal->hari }}</div>
                    <div><strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</div>
                </div>
            </div>
            <form method="POST" action="{{ url('/pasien/pendaftaran') }}">
                @csrf
                <input type="hidden" name="jadwal_periksa_id" value="{{ $jadwal->id }}">
                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
                    @error('keluhan')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <button class="btn btn-success">Daftar</button>
                <a href="{{ url('/pasien/pendaftaran') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

