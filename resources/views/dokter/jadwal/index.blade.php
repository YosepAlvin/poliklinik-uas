@extends('layouts.dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Jadwal Periksa</h4>
    <a href="{{ route('dokter.jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
  </div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
  <div class="card-body">
    <table class="table table-striped">
        <thead><tr><th>Poli</th><th>Hari</th><th>Jam</th><th style="width:160px">Aksi</th></tr></thead>
        <tbody>
        @forelse($items as $j)
            <tr>
                <td>{{ $j->poli->nama_poli ?? '-' }}</td>
                <td>{{ $j->hari }}</td>
                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{{ route('dokter.jadwal.edit', $j) }}">Edit</a>
                    <form method="POST" action="{{ route('dokter.jadwal.destroy', $j) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center">Belum ada jadwal.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $items->links() }}
  </div>
</div>
@endsection
