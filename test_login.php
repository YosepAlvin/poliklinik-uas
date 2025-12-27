<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;

$credentials = [
    'email' => 'tini@example.com',
    'password' => 'password',
];

if (Auth::attempt($credentials)) {
    echo "Login successful for tini@example.com with password 'password'\n";
} else {
    echo "Login FAILED for tini@example.com with password 'password'\n";
}
