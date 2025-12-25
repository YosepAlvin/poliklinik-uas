@extends('layouts.admin')

@section('content')
<h4 class="mb-3">Edit Poli</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.poli.update', $poli) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Poli</label>
                <input type="text" name="nama_poli" class="form-control" value="{{ old('nama_poli', $poli->nama_poli) }}" required>
                @error('nama_poli')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $poli->deskripsi) }}</textarea>
                @error('deskripsi')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                @php($status = old('status', $poli->status))
                <select name="status" class="form-select" required>
                    <option value="aktif" {{ $status==='aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $status==='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.poli.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
