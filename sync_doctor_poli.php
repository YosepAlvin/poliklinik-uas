<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\JadwalPeriksa;

echo "Syncing poli_id for doctors...\n";

$doctors = User::where('role', 'dokter')->get();

foreach ($doctors as $doctor) {
    // Get the first schedule to determine the poli
    $firstSchedule = JadwalPeriksa::where('dokter_id', $doctor->id)->first();
    if ($firstSchedule && $firstSchedule->poli_id) {
        $doctor->update(['poli_id' => $firstSchedule->poli_id]);
        echo "Updated Doctor {$doctor->name} with Poli ID {$firstSchedule->poli_id}\n";
    } else {
        echo "Doctor {$doctor->name} has no schedule, poli_id remains null.\n";
    }
}

echo "Done.\n";
