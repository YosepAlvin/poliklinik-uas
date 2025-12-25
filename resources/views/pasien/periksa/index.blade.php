@extends('layouts.pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Periksa</h4>
</div>
<div class="card">
    <div class="card-body">
        <p class="text-muted">Informasi pemeriksaan dan panduan akan ditampilkan di sini. Untuk mendaftar pemeriksaan, silakan pilih jadwal:</p>
        <a href="{{ route('pasien.pendaftaran.index') }}" class="btn btn-primary">Buka Jadwal</a>
    </div>
 </div>
@endsection

