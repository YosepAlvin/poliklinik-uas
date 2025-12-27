<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'no_rm' => '00856652',
                'nama' => 'Luis',
                'email' => 'luis@example.com',
                'tgl_lahir' => '1990-01-02',
                'alamat' => 'Jl. Diponegoro No. 22, Pekalongan',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567890',
            ],
            [
                'no_rm' => '00856658',
                'nama' => 'Rudi',
                'email' => 'rudi@example.com',
                'tgl_lahir' => '1983-09-09',
                'alamat' => 'Jl. Sudirman No. 15, Pekalongan',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567891',
            ],
            [
                'no_rm' => '00856663',
                'nama' => 'Tini',
                'email' => 'tini@example.com',
                'tgl_lahir' => '1996-05-18',
                'alamat' => 'Pekalongan',
                'jenis_kelamin' => 'P',
                'no_hp' => '08970065421',
            ],
            [
                'no_rm' => '00856647',
                'nama' => 'Bima',
                'email' => 'bima@example.com',
                'tgl_lahir' => '2004-05-21',
                'alamat' => 'jl.seroja raya no 25',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567892',
            ],
        ];

        foreach ($patients as $pData) {
            // 1. Ensure User exists
            $user = \App\Models\User::updateOrCreate(
                ['email' => $pData['email']],
                [
                    'name' => $pData['nama'],
                    'password' => 'password', // Laravel 11 hashed cast handles this
                    'role' => 'pasien',
                    'status' => 'aktif',
                ]
            );

            // 2. PRE-CLEANUP: If another record has this No RM, delete it to avoid unique constraint violation
            \App\Models\Pasien::where('no_rm', $pData['no_rm'])
                ->where('user_id', '!=', $user->id)
                ->delete();

            // 3. Ensure Pasien record is linked and updated
            \App\Models\Pasien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_rm' => $pData['no_rm'],
                    'nama' => $pData['nama'],
                    'tgl_lahir' => $pData['tgl_lahir'],
                    'alamat' => $pData['alamat'],
                    'jenis_kelamin' => $pData['jenis_kelamin'],
                    'no_hp' => $pData['no_hp'],
                ]
            );

            // 4. Post-cleanup of duplicates by name
            \App\Models\Pasien::where('nama', strtolower($pData['nama']))
                ->where('user_id', '!=', $user->id)
                ->delete();
        }
    }
}
