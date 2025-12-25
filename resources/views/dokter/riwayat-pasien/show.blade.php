@extends('layouts.dokter')

@section('content')
<h4 class="mb-3">Detail Pemeriksaan</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Data Pasien</h6>
                <div>Nama: {{ $periksa->daftarPoli->pasien->nama ?? '-' }}</div>
                <div>Keluhan: {{ $periksa->daftarPoli->keluhan ?? '-' }}</div>
                <div>No Antrian: {{ $periksa->daftarPoli->no_antrian ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Data Dokter</h6>
                <div>Nama: {{ $periksa->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</div>
                <div>Tanggal Periksa: {{ $periksa->tgl_periksa ? $periksa->tgl_periksa->format('d/m/Y H:i') : '-' }}</div>
                <div>Catatan: {{ $periksa->catatan }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="card-title">Daftar Obat</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Obat</th>
                    <th>Harga</th>
                </tr>
                </thead>
                <tbody>
                @php $totalObat = 0; @endphp
                @forelse($periksa->detailPeriksas as $d)
                    @php $totalObat += $d->harga; @endphp
                    <tr>
                        <td>{{ $d->obat->nama_obat ?? '-' }}</td>
                        <td>Rp{{ number_format($d->harga,0,',','.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Tidak ada obat.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th>Total Obat</th>
                    <th>Rp{{ number_format($totalObat,0,',','.') }}</th>
                </tr>
                <tr>
                    <th>Total Biaya</th>
                    <th>Rp{{ number_format($periksa->biaya,0,',','.') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('dokter.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

