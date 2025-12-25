@extends('layouts.pasien')

@section('content')
<h4 class="mb-3">Pilih Jadwal Periksa</h4>
<div class="card"><div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>Poli</th><th>Dokter</th><th>Hari</th><th>Jam</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($items as $j)
                <tr>
                    <td>{{ $j->poli->nama_poli ?? '-' }}</td>
                    <td>{{ $j->dokter->name ?? '-' }}</td>
                    <td>{{ $j->hari }}</td>
                    <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                    <td><a class="btn btn-primary btn-sm" href="{{ route('pasien.pendaftaran.create', $j->id) }}">Daftar</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada jadwal tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $items->links() }}
    </div>
</div></div>
@endsection
