@extends('layouts.admin')

@section('content')
<h4 class="mb-3">Tambah Pasien</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pasien.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">No RM</label>
                <input type="text" name="no_rm" class="form-control" value="{{ old('no_rm') }}" placeholder="Contoh: 202512-001">
                @error('no_rm')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
                @error('alamat')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}">
                @error('tgl_lahir')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
