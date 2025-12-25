@extends('layouts.pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Riwayat Pemeriksaan</h4>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead><tr><th>Tanggal</th><th>Dokter</th><th>Keluhan</th><th>Biaya</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php if($items->count() === 0){ ?>
                    <tr><td colspan="5" class="text-center">Belum ada riwayat.</td></tr>
                <?php } else { foreach($items as $p){ ?>
                    <tr>
                        <td>{{ $p->tgl_periksa ? $p->tgl_periksa->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $p->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</td>
                        <td>{{ $p->daftarPoli->keluhan ?? '-' }}</td>
                        <td>Rp{{ number_format($p->biaya,0,',','.') }}</td>
                        <td><a class="btn btn-sm btn-info" href="{{ route('pasien.riwayat.show', $p->id) }}">Detail</a></td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

