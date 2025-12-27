@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0">Selamat Datang, Admin {{ Auth::user()->name }}</h2>
        <p class="text-muted">Kelola data poliklinik Anda di sini.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-person-gear text-primary fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Manajemen User</h6>
                </div>
                <p class="text-muted mb-4">Kelola akun admin, dokter, dan pasien dalam satu tempat.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-person-badge text-success fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Kelola Dokter</h6>
                </div>
                <p class="text-muted mb-4">Tambah, ubah, dan hapus data dokter spesialis.</p>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-success w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-people text-info fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Kelola Pasien</h6>
                </div>
                <p class="text-muted mb-4">Manajemen data pasien dan rekam medis.</p>
                <a href="{{ route('admin.pasien.index') }}" class="btn btn-info text-white w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-hospital text-warning fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Kelola Poli</h6>
                </div>
                <p class="text-muted mb-4">Manajemen unit layanan poli klinik.</p>
                <a href="{{ route('admin.poli.index') }}" class="btn btn-warning text-white w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-capsule text-danger fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Obat</h6>
                </div>
                <p class="text-muted mb-4">Kelola daftar obat dan harga.</p>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-danger w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-dark bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-calendar-event text-dark fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Jadwal</h6>
                </div>
                <p class="text-muted mb-4">Kelola jadwal praktek dokter.</p>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-dark w-100">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-file-earmark-text text-secondary fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Laporan</h6>
                </div>
                <p class="text-muted mb-4">Lihat riwayat resep dan pemeriksaan.</p>
                <a href="{{ route('admin.resep.index') }}" class="btn btn-secondary w-100">Buka</a>
            </div>
        </div>
    </div>
</div>
@endsection
