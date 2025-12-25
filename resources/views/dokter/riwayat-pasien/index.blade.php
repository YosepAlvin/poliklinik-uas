@extends('layouts.dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Riwayat Pemeriksaan Pasien</h4>
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
                    <th>Tanggal</th>
                    <th>Biaya</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($riwayat as $p)
                    <tr>
                        <td>{{ $p->daftarPoli->no_antrian ?? '-' }}</td>
                        <td>{{ $p->daftarPoli->pasien->nama ?? '-' }}</td>
                        <td>{{ $p->daftarPoli->keluhan ?? '-' }}</td>
                        <td>{{ $p->tgl_periksa ? $p->tgl_periksa->format('d/m/Y H:i') : '-' }}</td>
                        <td>Rp{{ number_format($p->biaya,0,',','.') }}</td>
                        <td><a href="{{ route('dokter.riwayat.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada riwayat.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
@endsection

