@extends('layouts.admin')

@section('content')
<h4 class="mb-3">Edit Pasien</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pasien.update', $pasien) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pasien->nama) }}" required>
                @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
