@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Pasien</h4>
    <div>
        <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">Tambah Pasien</a>
    </div>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead><tr><th>Nama</th><th style="width:160px">Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $p)
                    <tr>
                        <td>{{ $p->nama }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{ route('admin.pasien.edit', $p) }}">Edit</a>
                            <form action="{{ route('admin.pasien.destroy', $p) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pasien?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection
