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
                    <th>No Antrian</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Jadwal</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($daftars as $d)
                    <tr>
                        <td>{{ $d->no_antrian }}</td>
                        <td>{{ $d->pasien->nama ?? '-' }}</td>
                        <td>{{ $d->keluhan }}</td>
                        <td>
                            {{ $d->jadwalPeriksa->hari ?? '' }}
                            {{ $d->jadwalPeriksa ? $d->jadwalPeriksa->jam_mulai.' - '.$d->jadwalPeriksa->jam_selesai : '' }}
                        </td>
                        <td>
                            <a href="{{ route('dokter.periksa.create', $d->id) }}" class="btn btn-primary btn-sm">Periksa</a>
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

