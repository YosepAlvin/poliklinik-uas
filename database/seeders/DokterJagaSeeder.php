<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Hash;

class DokterJagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poliUmumId = 1; // Berdasarkan pengecekan sebelumnya

        $doctors = [
            [
                'name' => 'dr. Raka Pratama',
                'email' => 'raka.pratama@puskesmas.go.id',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'poli_id' => $poliUmumId,
                'spesialisasi' => 'Dokter Umum',
                'unit' => 'UGD',
                'is_jaga' => true,
                'status' => 'aktif',
                'shifts' => [
                    ['hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Sabtu', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                    ['hari' => 'Minggu', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                ]
            ],
            [
                'name' => 'dr. Sinta Maharani',
                'email' => 'sinta.maharani@puskesmas.go.id',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'poli_id' => $poliUmumId,
                'spesialisasi' => 'Dokter Umum',
                'unit' => 'UGD',
                'is_jaga' => true,
                'status' => 'aktif',
                'shifts' => [
                    ['hari' => 'Senin', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Selasa', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Rabu', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Kamis', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Jumat', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Sabtu', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                    ['hari' => 'Minggu', 'jam_mulai' => '16:00', 'jam_selesai' => '00:00'],
                ]
            ],
            [
                'name' => 'dr. Aditya Wirawan',
                'email' => 'aditya.wirawan@puskesmas.go.id',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'poli_id' => $poliUmumId,
                'spesialisasi' => 'Dokter Umum',
                'unit' => 'UGD',
                'is_jaga' => true,
                'status' => 'aktif',
                'shifts' => [
                    ['hari' => 'Senin', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Selasa', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Rabu', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Kamis', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Jumat', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Sabtu', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                    ['hari' => 'Minggu', 'jam_mulai' => '00:00', 'jam_selesai' => '08:00'],
                ]
            ],
        ];

        foreach ($doctors as $docData) {
            $shifts = $docData['shifts'];
            unset($docData['shifts']);

            $doctor = User::updateOrCreate(
                ['email' => $docData['email']],
                $docData
            );

            foreach ($shifts as $shift) {
                JadwalPeriksa::updateOrCreate(
                    [
                        'dokter_id' => $doctor->id,
                        'hari' => $shift['hari'],
                    ],
                    [
                        'jam_mulai' => $shift['jam_mulai'],
                        'jam_selesai' => $shift['jam_selesai'],
                        'aktif' => true,
                    ]
                );
            }
        }
    }
}
