<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Models\Pasien;
use App\Models\DaftarPoli;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tiniUser = User::where('email', 'tini@example.com')->first();
if (!$tiniUser) {
    die("User Tini not found\n");
}

$pasien = $tiniUser->pasien;
if (!$pasien) {
    die("Pasien record for Tini not found\n");
}

echo "--- TINI REGISTRATION CHECK ---\n";
echo "Pasien ID: {$pasien->id} | Name: {$pasien->nama}\n";

$registrations = DaftarPoli::where('pasien_id', $pasien->id)->with('jadwalPeriksa.dokter')->get();

if ($registrations->isEmpty()) {
    echo "No registrations found for Tini in daftar_poli table.\n";
} else {
    foreach ($registrations as $reg) {
        echo "ID: {$reg->id}\n";
        echo "  Jadwal ID: {$reg->jadwal_periksa_id}\n";
        echo "  Dokter: " . ($reg->jadwalPeriksa->dokter->name ?? 'N/A') . " (ID: " . ($reg->jadwalPeriksa->dokter->id ?? 'N/A') . ")\n";
        echo "  Keluhan: {$reg->keluhan}\n";
        echo "  No Antrian: {$reg->no_antrian}\n";
        echo "  Status: " . ($reg->periksa ? 'ALREADY EXAMINED' : 'PENDING') . "\n";
        echo "---------------------------------\n";
    }
}

echo "\n--- CURRENT LOGGED IN DOCTOR INFO ---\n";
$dokter = User::where('role', 'dokter')->first(); // Assuming Budi is the one logged in
if ($dokter) {
    echo "Dokter Name: {$dokter->name} | ID: {$dokter->id}\n";
}
