@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Manajemen Resep</h4>
</div>
<div class="card"><div class="card-body">
<div class="table-responsive">
    <table class="table table-striped">
        <thead><tr><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Obat</th><th>Total</th></tr></thead>
        <tbody>
        <?php if($items->count() === 0){ ?>
            <tr><td colspan="5" class="text-center">Belum ada resep.</td></tr>
        <?php } else { foreach($items as $p){ ?>
            <tr>
                <td>{{ $p->tgl_periksa ? $p->tgl_periksa->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ $p->daftarPoli->pasien->nama ?? '-' }}</td>
                <td>{{ $p->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</td>
                <td>
                    <?php foreach($p->detailPeriksas as $d){ ?>
                        <div class="mb-1">
                            <span class="badge bg-primary">{{ $d->obat->nama_obat ?? '-' }}</span>
                            <small class="text-muted">{{ $d->jumlah }} x Rp{{ number_format($d->harga_saat_periksa,0,',','.') }}</small>
                        </div>
                    <?php } ?>
                </td>
                <td>
                    <div class="fw-bold text-primary">Rp{{ number_format($p->biaya,0,',','.') }}</div>
                    <small class="text-muted" style="font-size: 0.75rem;">(Inc. Admin)</small>
                </td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>
</div>
{{ $items->links() }}
</div></div>
@endsection
