@extends('layouts.dokter')

@section('content')
<h4 class="mb-3">Edit Jadwal</h4>
<form method="POST" action="{{ route('dokter.jadwal.update', $jadwal) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Poli</label>
        <select name="poli_id" class="form-select" required>
            <option value="">-- Pilih Poli --</option>
            @foreach($polis as $p)
                <option value="{{ $p->id }}" {{ $jadwal->poli_id == $p->id ? 'selected' : '' }}>{{ $p->nama_poli }}</option>
            @endforeach
        </select>
        @error('poli_id')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Hari</label>
        <input type="text" name="hari" class="form-control" value="{{ old('hari', $jadwal->hari) }}" required>
        @error('hari')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required>
        @error('jam_mulai')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required>
        @error('jam_selesai')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
 </form>
@endsection
