@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Kelola Poli</h4>
    <div class="d-flex gap-2">
        <form method="GET" class="d-flex">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control me-2" placeholder="Cari nama poli">
            <button class="btn btn-outline-secondary">Cari</button>
        </form>
        <a href="{{ route('admin.poli.create') }}" class="btn btn-primary">Tambah Poli</a>
    </div>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Nama Poli</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $p)
                    <tr>
                        <td>{{ ($items->currentPage()-1) * $items->perPage() + $loop->iteration }}</td>
                        <td>{{ $p->nama_poli }}</td>
                        <td>{{ $p->deskripsi ?? '-' }}</td>
                        <td>
                            @php $aktif = ($p->status ?? 'aktif') === 'aktif'; @endphp
                            <span class="badge {{ $aktif ? 'bg-success' : 'bg-danger' }}">{{ $aktif ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{ route('admin.poli.edit', $p) }}">Edit</a>
                            <form action="{{ route('admin.poli.destroy', $p) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus poli?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $items->appends(['q' => request('q')])->links() }}
        </div>
    </div>
</div>
@endsection
