@extends('layouts.dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Dashboard Dokter</h4>
    <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Periksa Pasien</h6>
            <p class="text-muted mb-3">Kelola pemeriksaan pasien dan catat resep.</p>
            <a class="btn btn-primary" href="{{ route('dokter.periksa.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Riwayat Pasien</h6>
            <p class="text-muted mb-3">Lihat riwayat pemeriksaan pasien.</p>
            <a class="btn btn-primary" href="{{ route('dokter.riwayat.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Jadwal Periksa</h6>
            <p class="text-muted mb-3">Lihat jadwal pemeriksaan.</p>
            <a class="btn btn-primary" href="{{ route('dokter.jadwal.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Resep</h6>
            <p class="text-muted mb-3">Kelola dan lihat resep pasien.</p>
            <a class="btn btn-primary" href="{{ route('dokter.resep.index') }}">Buka</a>
        </div></div>
    </div>
</div>
@endsection
