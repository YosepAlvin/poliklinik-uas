@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pendaftaran Pasien</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Form Pendaftaran -->
    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Pendaftaran Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                    @csrf
                    <h6 class="text-primary border-bottom pb-2 mb-3">DATA PASIEN</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Pasien</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tgl Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keluhan Awal</label>
                        <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="2" required>{{ old('keluhan') }}</textarea>
                    </div>

                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">DATA LAYANAN</h6>
                    <div class="mb-3">
                        <label class="form-label">Pilih Poli</label>
                        <select id="poli_id" name="poli_id" class="form-select @error('poli_id') is-invalid @enderror" required onchange="updateDokter(this.value)">
                            <option value="">-- Pilih Poli --</option>
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Dokter</label>
                        <select id="dokter_id" name="dokter_id" class="form-select @error('dokter_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                        <div class="form-text text-muted small">*Jika dokter tidak praktik di tgl tersebut, otomatis ke Dokter Jaga.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" class="form-control @error('tanggal_periksa') is-invalid @enderror" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Daftarkan Pasien</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Pendaftaran Terakhir -->
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Pendaftaran Hari Ini</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>RM / Nama</th>
                                <th>Layanan</th>
                                <th>Antrian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarans as $dp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $dp->pasien->no_rm }}</div>
                                    <div class="small text-muted">{{ $dp->pasien->nama }}</div>
                                </td>
                                <td>
                                    <div class="small fw-bold">{{ $dp->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</div>
                                    <div class="small text-muted">{{ $dp->jadwalPeriksa->dokter->name ?? '-' }}</div>
                                    <div class="small fst-italic">{{ $dp->tanggal_periksa ? $dp->tanggal_periksa->format('d/m/Y') : '-' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-dark fs-6">{{ $dp->no_antrian }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'menunggu' => 'bg-warning text-dark',
                                            'diperiksa' => 'bg-info text-white',
                                            'selesai' => 'bg-success text-white'
                                        ][$dp->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($dp->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada data pendaftaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $pendaftarans->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function updateDokter(poliId) {
        const dokterSelect = document.getElementById('dokter_id');
        dokterSelect.innerHTML = '<option value="">-- Loading... --</option>';
        
        if (!poliId) {
            dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
            return;
        }

        fetch(`/admin/pendaftaran/get-dokter/${poliId}`)
            .then(response => response.json())
            .then(data => {
                dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
                data.forEach(dokter => {
                    const suffix = dokter.is_jaga ? ' (Dokter Jaga)' : '';
                    const option = document.createElement('option');
                    option.value = dokter.id;
                    option.textContent = dokter.name + suffix;
                    dokterSelect.appendChild(option);
                });
            });
    }
</script>
@endsection
