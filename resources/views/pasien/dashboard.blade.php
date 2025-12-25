@extends('layouts.pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Dashboard Pasien</h4>
    <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Periksa</h6>
            <p class="text-muted mb-3">Informasi terkait pemeriksaan dokter.</p>
            <a class="btn btn-primary" href="{{ route('pasien.periksa.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Riwayat</h6>
            <p class="text-muted mb-3">Riwayat pemeriksaan Anda.</p>
            <a class="btn btn-primary" href="{{ route('pasien.riwayat.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Resep</h6>
            <p class="text-muted mb-3">Lihat resep yang diberikan dokter.</p>
            <a class="btn btn-primary" href="{{ route('pasien.resep.index') }}">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Jadwal</h6>
            <p class="text-muted mb-3">Daftar jadwal periksa dan nomor antrian.</p>
            <a class="btn btn-primary" href="{{ route('pasien.pendaftaran.index') }}">Buka</a>
        </div></div>
    </div>
</div>
@endsection
