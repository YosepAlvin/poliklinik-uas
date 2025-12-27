<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\DaftarPoli;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$allRegs = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter'])->orderBy('no_antrian')->get();

echo "--- ALL REGISTRATIONS ---\n";
foreach ($allRegs as $reg) {
    echo "ID: {$reg->id} | No Antrian: {$reg->no_antrian} | Pasien: {$reg->pasien->nama} | Dokter: {$reg->jadwalPeriksa->dokter->name} (ID: {$reg->jadwalPeriksa->dokter->id}) | Status: " . ($reg->periksa ? 'DONE' : 'PENDING') . "\n";
}
echo "---------------------------\n";
