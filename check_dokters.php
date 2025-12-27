<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dokters = User::where('role', 'dokter')->get();

echo "--- DOCTOR LIST ---\n";
foreach ($dokters as $d) {
    echo "ID: {$d->id} | Name: {$d->name} | Email: {$d->email}\n";
}
echo "-------------------\n";
