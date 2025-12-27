@extends('layouts.dokter')

@section('content')
<h4 class="mb-3">Detail Pemeriksaan</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Data Pasien</h6>
                <div><strong>No RM:</strong> <code class="fw-bold">{{ $periksa->daftarPoli->pasien->no_rm ?? '-' }}</code></div>
                <div><strong>Nama:</strong> {{ $periksa->daftarPoli->pasien->nama ?? '-' }}</div>
                <div><strong>Jenis Kelamin:</strong> {{ $periksa->daftarPoli->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($periksa->daftarPoli->pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                <div><strong>Umur:</strong> {{ $periksa->daftarPoli->pasien->umur }}</div>
                <div><strong>Alamat:</strong> {{ $periksa->daftarPoli->pasien->alamat ?? '-' }}</div>
                <hr>
                <div><strong>Keluhan:</strong> {{ $periksa->daftarPoli->keluhan ?? '-' }}</div>
                <div><strong>No Antrian:</strong> {{ $periksa->daftarPoli->no_antrian ?? '-' }}</div>
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
                    <th>Jml</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @php $totalObat = 0; @endphp
                @forelse($periksa->detailPeriksas as $d)
                    @php $subtotal = $d->harga_saat_periksa * $d->jumlah; $totalObat += $subtotal; @endphp
                    <tr>
                        <td>{{ $d->obat->nama_obat ?? '-' }}</td>
                        <td>Rp{{ number_format($d->harga_saat_periksa,0,',','.') }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp{{ number_format($subtotal,0,',','.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada obat.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Obat</th>
                    <th>Rp{{ number_format($totalObat,0,',','.') }}</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-end">Total Biaya (Inc. Admin)</th>
                    <th>Rp{{ number_format($periksa->biaya,0,',','.') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('dokter.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

