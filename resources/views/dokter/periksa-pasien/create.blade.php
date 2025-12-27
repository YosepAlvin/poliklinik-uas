@extends('layouts.dokter')

@section('content')
<h4 class="mb-3">Pemeriksaan Pasien</h4>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div><strong>No RM:</strong> <code class="fw-bold">{{ $daftar->pasien->no_rm ?? '-' }}</code></div>
                <div><strong>Nama Pasien:</strong> {{ $daftar->pasien->nama ?? '-' }}</div>
                <div><strong>Jenis Kelamin:</strong> {{ $daftar->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($daftar->pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                <div><strong>Umur:</strong> {{ $daftar->pasien->umur }}</div>
                <div><strong>Alamat:</strong> {{ $daftar->pasien->alamat ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div><strong>Keluhan:</strong> {{ $daftar->keluhan }}</div>
                <div><strong>No Antrian:</strong> {{ $daftar->no_antrian }}</div>
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
            const subtotal = item.harga * item.jumlah;
            totalObat += subtotal;
            
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex flex-column mb-2 border rounded';
            li.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-bold">${item.nama}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeObat(${idx})">Hapus</button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <span class="input-group-text">Jml</span>
                        <input type="number" class="form-control" value="${item.jumlah}" min="1" max="${item.stok}" onchange="updateJumlah(${idx}, this.value)">
                    </div>
                    <span class="text-primary fw-bold">${formatRupiah(subtotal)}</span>
                </div>
                <small class="text-muted mt-1">Harga Satuan: ${formatRupiah(item.harga)} | Tersedia: ${item.stok}</small>
            `;
            list.appendChild(li);
        });
        totalObatEl.textContent = formatRupiah(totalObat);
        totalBayarEl.textContent = formatRupiah(totalObat + adminFee);
        hiddenJson.value = JSON.stringify(selected.map(s => ({id: s.id, jumlah: s.jumlah})));
    }

    window.removeObat = function(idx) {
        selected.splice(idx, 1);
        render();
    };

    window.updateJumlah = function(idx, val) {
        const jumlah = parseInt(val);
        if (isNaN(jumlah) || jumlah < 1) {
            selected[idx].jumlah = 1;
        } else if (jumlah > selected[idx].stok) {
            alert('Stok obat tidak mencukupi (Tersedia: ' + selected[idx].stok + ')');
            selected[idx].jumlah = selected[idx].stok;
        } else {
            selected[idx].jumlah = jumlah;
        }
        render();
    };

    addBtn.addEventListener('click', () => {
        const id = parseInt(select.value);
        if (!id) return;

        // Cek jika obat sudah ada di list
        if (selected.find(s => s.id === id)) {
            alert('Obat sudah ada dalam daftar. Silakan ubah jumlahnya.');
            return;
        }

        const option = select.selectedOptions[0];
        const price = parseInt(option.dataset.price);
        const name = option.text.split('(')[0].trim();
        const stock = parseInt(option.dataset.stock);

        if (stock <= 0) {
            alert('Stok obat habis');
            return;
        }

        selected.push({id, harga: price, nama: name, stok: stock, jumlah: 1});
        render();
        select.value = '';
    });
</script>
@endpush
