@extends('layouts.dokter')

@section('content')
<h4 class="mb-3">Pemeriksaan Pasien</h4>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div><strong>Nama Pasien:</strong> {{ $daftar->pasien->nama ?? '-' }}</div>
                <div><strong>Keluhan:</strong> {{ $daftar->keluhan }}</div>
                <div><strong>No Antrian:</strong> {{ $daftar->no_antrian }}</div>
            </div>
            <div class="col-md-6">
                <div><strong>Jadwal:</strong> {{ $daftar->jadwalPeriksa->hari ?? '' }} {{ $daftar->jadwalPeriksa ? $daftar->jadwalPeriksa->jam_mulai.' - '.$daftar->jadwalPeriksa->jam_selesai : '' }}</div>
            </div>
        </div>
    </div>
 </div>

<form method="POST" action="{{ route('dokter.periksa.store') }}">
    @csrf
    <input type="hidden" name="daftar_poli_id" value="{{ $daftar->id }}">
    <input type="hidden" name="obat_json" id="obat_json">

    <div class="mb-3">
        <label class="form-label">Catatan Pemeriksaan</label>
        <textarea name="catatan" class="form-control" rows="3" required>{{ old('catatan') }}</textarea>
        @error('catatan')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Pilih Obat</label>
            <div class="input-group mb-3">
                <select id="obat_select" class="form-select">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obats as $o)
                        <option value="{{ $o->id }}" data-price="{{ $o->harga }}" data-stock="{{ $o->stok }}" {{ ($o->stok ?? 0) <= 0 ? 'disabled' : '' }}>
                            {{ $o->nama_obat }} (Rp{{ number_format($o->harga,0,',','.') }}) — Stok: {{ $o->stok ?? 0 }}{{ ($o->stok ?? 0) <= 5 ? ' ⚠️' : '' }}
                        </option>
                    @endforeach
                </select>
                <button type="button" id="add_obat" class="btn btn-outline-primary">Tambah</button>
            </div>

            <ul class="list-group" id="selected_obat"></ul>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span>Total Obat</span>
                        <strong id="total_obat">Rp0</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Biaya Admin</span>
                        <strong>Rp150.000</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Total Bayar</span>
                        <strong id="total_bayar">Rp150.000</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button class="btn btn-success">Simpan Pemeriksaan</button>
        <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const adminFee = 150000;
    const select = document.getElementById('obat_select');
    const addBtn = document.getElementById('add_obat');
    const list = document.getElementById('selected_obat');
    const totalObatEl = document.getElementById('total_obat');
    const totalBayarEl = document.getElementById('total_bayar');
    const hiddenJson = document.getElementById('obat_json');

    let selected = [];

    function formatRupiah(n) {
        return 'Rp' + n.toLocaleString('id-ID');
    }

    function render() {
        list.innerHTML = '';
        let totalObat = 0;
        selected.forEach((item, idx) => {
            totalObat += item.harga;
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `${item.nama} <span class="badge bg-primary rounded-pill">${formatRupiah(item.harga)}</span>`;
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-outline-danger';
            removeBtn.textContent = 'Hapus';
            removeBtn.addEventListener('click', () => {
                selected.splice(idx, 1);
                render();
            });
            li.appendChild(removeBtn);
            list.appendChild(li);
        });
        totalObatEl.textContent = formatRupiah(totalObat);
        totalBayarEl.textContent = formatRupiah(totalObat + adminFee);
        hiddenJson.value = JSON.stringify(selected.map(s => ({id: s.id})));
    }

    addBtn.addEventListener('click', () => {
        const id = parseInt(select.value);
        if (!id) return;
        const price = parseInt(select.selectedOptions[0].dataset.price);
        const name = select.selectedOptions[0].textContent;
        const stock = parseInt(select.selectedOptions[0].dataset.stock);
        if (stock <= 0) {
            alert('Stok obat habis');
            return;
        }
        selected.push({id, harga: price, nama: name});
        render();
        select.value = '';
    });
</script>
@endpush
