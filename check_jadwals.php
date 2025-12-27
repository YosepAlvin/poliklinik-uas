<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\JadwalPeriksa;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jadwals = JadwalPeriksa::with(['dokter', 'poli'])->get();

echo "--- JADWAL PERIKSA LIST ---\n";
foreach ($jadwals as $j) {
    $dokterName = $j->dokter->name ?? 'N/A';
    $dokterId = $j->dokter->id ?? 'N/A';
    $poliName = $j->poli->nama_poli ?? 'N/A';
    echo "ID: {$j->id} | Dokter: {$dokterName} (ID: {$dokterId}) | Poli: {$poliName} | Hari: {$j->hari} | Jam: {$j->jam_mulai} - {$j->jam_selesai}\n";
}
echo "---------------------------\n";
