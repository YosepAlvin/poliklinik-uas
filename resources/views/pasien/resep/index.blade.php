@extends('layouts.pasien')

@section('content')
<h4 class="mb-3">Resep Saya</h4>
<div class="card"><div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>Tanggal</th><th>Dokter</th><th>Resep (Obat)</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($items as $p)
                @php $total = $p->detailPeriksas->sum('harga'); @endphp
                <tr>
                    <td>{{ $p->tgl_periksa ? $p->tgl_periksa->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $p->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</td>
                    <td>
                        @foreach($p->detailPeriksas as $d)
                            <span class="badge bg-primary me-1">{{ $d->obat->nama_obat ?? '-' }}</span>
                        @endforeach
                    </td>
                    <td>Rp{{ number_format($total,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Belum ada resep.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $items->links() }}
    </div>
</div></div>
@endsection
