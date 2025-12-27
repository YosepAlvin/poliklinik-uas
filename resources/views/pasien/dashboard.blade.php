@extends('layouts.pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0">Selamat Datang, Pasien {{ Auth::user()->name }}</h2>
        <p class="text-muted">Pantau kesehatan Anda dan atur kunjungan dokter di sini.</p>
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
                            <a href="{{ route('pasien.profile') }}" class="btn btn-sm btn-outline-primary">Edit Profil</a>
                        </div>
                        @php $pasien = Auth::user()->pasien; @endphp
                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-muted d-block">No. RM</small>
                                <code class="fw-bold">{{ $pasien->no_rm ?? '-' }}</code>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Tanggal Lahir</small>
                                <span>{{ $pasien->tgl_lahir ? $pasien->tgl_lahir->format('d/m/Y') : '-' }} ({{ $pasien->umur }})</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Jenis Kelamin</small>
                                <span>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Alamat</small>
                                <span class="text-truncate d-block" title="{{ $pasien->alamat ?? '-' }}">{{ $pasien->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
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
                    <h6 class="card-title mb-0">Periksa</h6>
                </div>
                <p class="text-muted mb-4">Lihat informasi terkait hasil pemeriksaan dokter terbaru Anda.</p>
                <a class="btn btn-primary w-100" href="{{ route('pasien.periksa.index') }}">Buka</a>
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
                    <h6 class="card-title mb-0">Riwayat</h6>
                </div>
                <p class="text-muted mb-4">Akses riwayat medis dan catatan kesehatan Anda sebelumnya.</p>
                <a class="btn btn-success w-100" href="{{ route('pasien.riwayat.index') }}">Buka</a>
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
                <p class="text-muted mb-4">Lihat daftar resep obat yang telah diberikan oleh dokter.</p>
                <a class="btn btn-warning text-white w-100" href="{{ route('pasien.resep.index') }}">Buka</a>
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
                    <h6 class="card-title mb-0">Jadwal</h6>
                </div>
                <p class="text-muted mb-4">Cek jadwal periksa dan ambil nomor antrian untuk berobat.</p>
                <a class="btn btn-info text-white w-100" href="{{ route('pasien.pendaftaran.index') }}">Buka</a>
            </div>
        </div>
    </div>
</div>
@endsection
