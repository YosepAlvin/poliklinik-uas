@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Dashboard Admin</h4>
    <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
    </div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Kelola Dokter</h6>
            <p class="text-muted mb-3">Tambah, ubah, dan hapus data dokter.</p>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Kelola Pasien</h6>
            <p class="text-muted mb-3">Manajemen data pasien klinik.</p>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Kelola Poli</h6>
            <p class="text-muted mb-3">Manajemen data poli klinik.</p>
            <a href="{{ route('admin.poli.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Obat</h6>
            <p class="text-muted mb-3">CRUD obat dan stok.</p>
            <a href="{{ route('admin.obat.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Jadwal</h6>
            <p class="text-muted mb-3">Kelola jadwal (segera hadir).</p>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-3"><div class="card-body">
            <h6 class="card-title">Laporan</h6>
            <p class="text-muted mb-3">Lihat laporan resep dan pemeriksaan.</p>
            <a href="{{ route('admin.resep.index') }}" class="btn btn-primary">Buka</a>
        </div></div>
    </div>
</div>
@endsection
