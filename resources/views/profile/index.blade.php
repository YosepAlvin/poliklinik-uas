@extends('layouts.' . auth()->user()->role)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Profil Pengguna</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm text-center mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}" 
                         alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #f8f9fa;">
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ ucfirst($user->role) }}</p>
                <div class="badge bg-{{ $user->status === 'aktif' ? 'success' : 'secondary' }} mb-3">
                    {{ ucfirst($user->status) }}
                </div>
                <hr>
                <p class="text-start mb-1"><strong>Email:</strong></p>
                <p class="text-start text-muted">{{ $user->email }}</p>
                
                @if($user->role === 'dokter')
                    <p class="text-start mb-1"><strong>Poli:</strong></p>
                    <p class="text-start text-muted">{{ $user->poli->nama_poli ?? '-' }}</p>
                    <p class="text-start mb-1"><strong>Jenis Kelamin:</strong></p>
                    <p class="text-start text-muted">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    <p class="text-start mb-1"><strong>Tanggal Lahir:</strong></p>
                    <p class="text-start text-muted">{{ $user->tgl_lahir ? $user->tgl_lahir->format('d M Y') : '-' }}</p>
                    <p class="text-start mb-1"><strong>No. HP:</strong></p>
                    <p class="text-start text-muted">{{ $user->no_hp ?? '-' }}</p>
                    <p class="text-start mb-1"><strong>Alamat:</strong></p>
                    <p class="text-start text-muted">{{ $user->alamat ?? '-' }}</p>
                @elseif($user->role === 'pasien')
                    @if($pasien)
                        <p class="text-start mb-1"><strong>No. RM:</strong></p>
                        <p class="text-start text-muted"><code class="fw-bold">{{ $pasien->no_rm ?? '-' }}</code></p>
                        <p class="text-start mb-1"><strong>Nama Medis:</strong></p>
                        <p class="text-start text-muted">{{ $pasien->nama ?? '-' }}</p>
                        <p class="text-start mb-1"><strong>Jenis Kelamin:</strong></p>
                        <p class="text-start text-muted">{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                        <p class="text-start mb-1"><strong>Tanggal Lahir:</strong></p>
                        <p class="text-start text-muted">{{ $pasien->tgl_lahir ? $pasien->tgl_lahir->format('d M Y') : '-' }} ({{ $pasien->umur }})</p>
                        <p class="text-start mb-1"><strong>No. HP:</strong></p>
                        <p class="text-start text-muted">{{ $pasien->no_hp ?? '-' }}</p>
                        <p class="text-start mb-1"><strong>Alamat:</strong></p>
                        <p class="text-start text-muted">{{ $pasien->alamat ?? '-' }}</p>
                    @else
                        <div class="alert alert-warning py-2 small">Data medis belum lengkap.</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route(auth()->user()->role . '.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ganti Avatar (JPG/PNG, max 2MB)</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/jpeg,image/png">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($user->role === 'dokter')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '') }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="poli_id" class="form-label">Poli</label>
                                <select class="form-select @error('poli_id') is-invalid @enderror" id="poli_id" name="poli_id" required>
                                    <option value="">-- Pilih Poli --</option>
                                    @foreach($polis as $poli)
                                        <option value="{{ $poli->id }}" {{ old('poli_id', $user->poli_id) == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                                    @endforeach
                                </select>
                                @error('poli_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $user->tgl_lahir ? $user->tgl_lahir->format('Y-m-d') : '') }}">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @elseif($user->role === 'pasien')
                        <div class="mb-3">
                            <label for="nama_medis" class="form-label">Nama Medis (Wajib)</label>
                            <input type="text" class="form-control @error('nama_medis') is-invalid @enderror" id="nama_medis" name="nama_medis" value="{{ old('nama_medis', $pasien->nama ?? $user->name) }}" required>
                            @error('nama_medis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $pasien->no_hp ?? '') }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', ($pasien && $pasien->tgl_lahir) ? $pasien->tgl_lahir->format('Y-m-d') : '') }}">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <hr class="my-4">
                    <h6 class="mb-3">Ganti Password</h6>
                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password.</p>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
