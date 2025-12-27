@extends('layouts.dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0">Selamat Datang, Dokter {{ Auth::user()->name }}</h2>
        <p class="text-muted">Pantau jadwal dan periksa pasien Anda hari ini.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}" 
                             alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #f8f9fa;">
                    </div>
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                            <a href="{{ route('dokter.profile') }}" class="btn btn-sm btn-outline-primary">Edit Profil</a>
                        </div>
                        @php 
                            $poli = Auth::user()->poli->nama_poli ?? '-';
                        @endphp
                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-muted d-block">Spesialis (Poli)</small>
                                <span class="fw-bold text-primary">{{ $poli }}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Email</small>
                                <span>{{ Auth::user()->email }}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-{{ Auth::user()->status === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst(Auth::user()->status) }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Alamat</small>
                                <span class="text-truncate d-block" title="{{ Auth::user()->alamat ?? '-' }}">{{ Auth::user()->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-people text-primary fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Pasien Menunggu</h6>
                    <h3 class="mb-0 fw-bold">{{ $pasienMenunggu }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 border-start border-success border-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-check2-circle text-success fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Total Diperiksa</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalDiperiksa }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-clipboard2-pulse text-primary fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Periksa Pasien</h6>
                </div>
                <p class="text-muted mb-4">Kelola pemeriksaan pasien dan catat diagnosa medis.</p>
                <a class="btn btn-primary w-100" href="{{ route('dokter.periksa.index') }}">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-clock-history text-success fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Riwayat Pasien</h6>
                </div>
                <p class="text-muted mb-4">Lihat catatan medis dan riwayat kunjungan pasien.</p>
                <a class="btn btn-success w-100" href="{{ route('dokter.riwayat.index') }}">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-calendar-check text-info fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Jadwal Periksa</h6>
                </div>
                <p class="text-muted mb-4">Atur dan lihat jadwal praktek Anda di klinik.</p>
                <a class="btn btn-info text-white w-100" href="{{ route('dokter.jadwal.index') }}">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-prescription text-warning fs-4"></i>
                    </div>
                    <h6 class="card-title mb-0">Resep</h6>
                </div>
                <p class="text-muted mb-4">Kelola dan cetak resep obat untuk pasien.</p>
                <a class="btn btn-warning text-white w-100" href="{{ route('dokter.resep.index') }}">Buka</a>
            </div>
        </div>
    </div>
</div>
@endsection
