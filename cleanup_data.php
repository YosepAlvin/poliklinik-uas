<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\DB;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function() {
    $mainBudi = User::where('email', 'dokterbudi@example.com')->first();
    $dupBudi = User::where('email', 'dokter@example.com')->first();

    if ($mainBudi && $dupBudi && $mainBudi->id != $dupBudi->id) {
        echo "Merging Dokter ID {$dupBudi->id} into ID {$mainBudi->id}...\n";
        
        // Reassign JadwalPeriksa
        JadwalPeriksa::where('dokter_id', $dupBudi->id)->update(['dokter_id' => $mainBudi->id]);
        
        // Reassign any other things if needed (e.g. if there are other tables)
        // For now JadwalPeriksa is the main link.
        
        // Delete duplicate user
        $dupBudi->delete();
        echo "Duplicate doctor deleted.\n";
    }

    // Fix missing Poli in JadwalPeriksa
    $umum = DB::table('poli')->where('nama_poli', 'Umum')->first();
    if ($umum) {
        JadwalPeriksa::whereNull('poli_id')->update(['poli_id' => $umum->id]);
        echo "Fixed schedules with missing Poli ID.\n";
    }

    // Recalculate Tini's antrian if she's the one we're fixing
    $tiniUser = User::where('email', 'tini@example.com')->first();
    if ($tiniUser && $tiniUser->pasien) {
        $tiniPasienId = $tiniUser->pasien->id;
        
        // Let's just make sure Tini has a proper registration for antrian 3 as requested
        // First, see current regs for Tini
        $tiniRegs = DaftarPoli::where('pasien_id', $tiniPasienId)->get();
        foreach ($tiniRegs as $reg) {
            // Re-calculate antrian based on the potentially new doctor/schedule context
            $lastNo = DaftarPoli::where('jadwal_periksa_id', $reg->jadwal_periksa_id)
                ->where('id', '!=', $reg->id)
                ->max('no_antrian') ?? 0;
            $newNo = $lastNo + 1;
            $reg->update(['no_antrian' => $newNo]);
            echo "Updated Tini's registration ID {$reg->id} to No Antrian {$newNo}\n";
        }
    }
});

echo "Cleanup completed.\n";
