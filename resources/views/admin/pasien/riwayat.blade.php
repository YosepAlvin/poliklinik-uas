@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Riwayat Periksa Pasien: {{ $pasien->nama }}</h4>
    <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Informasi Pasien</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>No RM</th><td>: <code class="fw-bold">{{ $pasien->no_rm ?? '-' }}</code></td></tr>
                    <tr><th>Nama</th><td>: {{ $pasien->nama }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>: {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td></tr>
                    <tr><th>Umur</th><td>: {{ $pasien->umur }}</td></tr>
                    <tr><th>Tgl Lahir</th><td>: {{ $pasien->tgl_lahir ? $pasien->tgl_lahir->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Alamat</th><td>: {{ $pasien->alamat ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @forelse($periksas as $p)
            <div class="card mb-3 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title text-info">
                            <i class="bi bi-calendar-event"></i> {{ $p->tgl_periksa ? $p->tgl_periksa->format('d M Y H:i') : '-' }}
                        </h5>
                        <span class="badge bg-success">Rp{{ number_format($p->biaya, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2">
                        <strong>Dokter:</strong> {{ $p->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}<br>
                        <strong>Keluhan:</strong> <span class="text-muted italic">"{{ $p->daftarPoli->keluhan ?? '-' }}"</span><br>
                        <strong>Catatan Dokter:</strong> {{ $p->catatan ?? '-' }}
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-uppercase fw-bold text-muted">Resep Obat:</small>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @forelse($p->detailPeriksas as $d)
                                <span class="badge bg-light text-dark border">
                                    {{ $d->obat->nama_obat ?? '-' }} ({{ $d->jumlah }})
                                </span>
                            @empty
                                <small class="text-muted italic">Tidak ada resep.</small>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">Belum ada riwayat pemeriksaan untuk pasien ini.</div>
        @endforelse

        <div class="mt-3">
            {{ $periksas->links() }}
        </div>
    </div>
</div>
@endsection
