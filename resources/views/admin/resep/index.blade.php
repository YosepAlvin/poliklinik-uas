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
            <?php $total = $p->detailPeriksas->sum('harga'); ?>
            <tr>
                <td>{{ $p->tgl_periksa ? $p->tgl_periksa->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ $p->daftarPoli->pasien->nama ?? '-' }}</td>
                <td>{{ $p->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</td>
                <td>
                    <?php foreach($p->detailPeriksas as $d){ ?>
                        <span class="badge bg-primary me-1">{{ $d->obat->nama_obat ?? '-' }}</span>
                    <?php } ?>
                </td>
                <td>Rp{{ number_format($total,0,',','.') }}</td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>
</div>
{{ $items->links() }}
</div></div>
@endsection
