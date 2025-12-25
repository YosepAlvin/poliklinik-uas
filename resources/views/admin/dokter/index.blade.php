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
        <thead><tr><th>Nama</th><th>Email</th><th style="width:160px">Aksi</th></tr></thead>
        <tbody>
        @if($items->count() === 0)
            <tr><td colspan="3" class="text-center">Belum ada data.</td></tr>
        @else
            @foreach($items as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->email }}</td>
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
