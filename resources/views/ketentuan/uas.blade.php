<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ketentuan UAS Divisi Web Developer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Poliklinik</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ url('/ketentuan-uas') }}"><i class="bi bi-journal-text"></i> Ketentuan UAS</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
        </ul>
    </div>
</nav>
<div class="container py-4">
    <h3 class="mb-3">Ketentuan Umum Ujian Akhir Semester (UAS)</h3>
    <div class="card">
        <div class="card-body">
            <p>Bagi anggota Divisi Web Developer diwajibkan mengikuti Ujian Akhir Semester (UAS) dengan ketentuan sebagai berikut:</p>
            <h5 class="mt-3">a. Ruang Lingkup UAS</h5>
            <p>Mahasiswa mengerjakan:</p>
            <ol>
                <li>Modul 13-14</li>
                <li>Project Capstone sesuai ketentuan berikut:</li>
            </ol>
            <h6 class="mt-2">a. Manajemen Stok Obat</h6>
            <ol>
                <li>Admin dapat menambah stok dan mengurangi stok obat secara manual.</li>
                <li>Sistem otomatis mengurangi stok jika dokter memberikan resep pada pasien.</li>
            </ol>
            <h6 class="mt-2">b. Handling stok habis</h6>
            <ol>
                <li>Sistem harus memberikan validasi dan notifikasi/error handling ketika stok obat habis.</li>
                <li>Opsional: Tampilkan indikator stok menipis (jika ingin menambah nilai plus).</li>
            </ol>
            <h6 class="mt-2">c. Integrasi dengan modul sebelumnya</h6>
            <p>Integrasi dengan CRUD Obat, Jadwal Periksa, Resep Dokter, dll.</p>
        </div>
    </div>
</div>
</body>
</html>

