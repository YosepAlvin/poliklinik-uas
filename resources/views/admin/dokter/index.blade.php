@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Dokter</h4>
    <div>
        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">Tambah Dokter</a>
    </div>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Poli</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th style="width:160px">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @if($items->count() === 0)
            <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
        @else
            @foreach($items as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->poli->nama_poli ?? '-' }}</td>
                <td>{{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : ($d->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                <td>{{ $d->tgl_lahir ? $d->tgl_lahir->format('d/m/Y') : '-' }}</td>
                <td>{{ $d->alamat ?? '-' }}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{{ route('admin.dokter.edit', $d) }}">Edit</a>
                    <form action="{{ route('admin.dokter.destroy', $d) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokter?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
{{ $items->links() }}
<p class="text-muted">Role dokter ditandai pada kolom `role` user.</p>
@endsection
