@extends('layouts.dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Pasien Untuk Diperiksa</h4>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="10%">No Antrian</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Poli / Jadwal</th>
                    <th width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($daftars as $d)
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-primary fs-6">{{ $d->no_antrian }}</span>
                        </td>
                        <td><code>{{ $d->pasien->no_rm ?? '-' }}</code></td>
                        <td class="fw-bold">{{ $d->pasien->nama ?? '-' }}</td>
                        <td>{{ Str::limit($d->keluhan, 50) }}</td>
                        <td>
                            <div class="small fw-bold text-primary">{{ $d->jadwalPeriksa->poli->nama_poli ?? 'Umum' }}</div>
                            <div class="small text-muted">
                                {{ $d->jadwalPeriksa->hari ?? '' }}, 
                                {{ $d->jadwalPeriksa ? $d->jadwalPeriksa->jam_mulai.' - '.$d->jadwalPeriksa->jam_selesai : '' }}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('dokter.periksa.create', $d->id) }}" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-stethoscope"></i> Periksa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pasien menunggu.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
@endsection

