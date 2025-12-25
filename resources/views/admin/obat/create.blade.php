@php($title = 'Tambah Obat')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h4 class="mb-3">{{ $title }}</h4>
    <form method="POST" action="{{ route('admin.obat.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required>
            @error('nama_obat')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" min="0" required>
            @error('harga')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
            @error('stok')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
