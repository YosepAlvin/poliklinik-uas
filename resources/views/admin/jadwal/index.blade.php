@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Jadwal Periksa</h4>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead><tr><th>Poli</th><th>Dokter</th><th>Hari</th><th>Jam</th></tr></thead>
                <tbody>
                <?php if($items->count() === 0){ ?>
                    <tr><td colspan="4" class="text-center">Tidak ada jadwal.</td></tr>
                <?php } else { foreach($items as $j){ ?>
                    <tr>
                        <td>{{ $j->poli->nama_poli ?? '-' }}</td>
                        <td>{{ $j->dokter->name ?? '-' }}</td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

