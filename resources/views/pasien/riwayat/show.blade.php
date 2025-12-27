@extends('layouts.pasien')

@section('content')
<h4 class="mb-3">Detail Pemeriksaan</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div>Nama Pasien: {{ $periksa->daftarPoli->pasien->nama ?? '-' }}</div>
                <div>Keluhan: {{ $periksa->daftarPoli->keluhan ?? '-' }}</div>
                <div>No Antrian: {{ $periksa->daftarPoli->no_antrian ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div>Dokter: {{ $periksa->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</div>
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
                <thead><tr><th>Obat</th><th>Harga</th><th>Jml</th><th>Subtotal</th></tr></thead>
                <tbody>
                <?php if($periksa->detailPeriksas->count() === 0){ ?>
                    <tr><td colspan="4" class="text-center">Tidak ada obat.</td></tr>
                <?php } else { foreach($periksa->detailPeriksas as $d){ ?>
                    <tr>
                        <td>{{ $d->obat->nama_obat ?? '-' }}</td>
                        <td>Rp{{ number_format($d->harga_saat_periksa,0,',','.') }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp{{ number_format($d->harga_saat_periksa * $d->jumlah,0,',','.') }}</td>
                    </tr>
                <?php } } ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Biaya Periksa (Termasuk Admin)</th>
                    <th>Rp{{ number_format($periksa->biaya,0,',','.') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

