<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        $dokter = User::updateOrCreate(
            ['email' => 'dokter@example.com'],
            ['name' => 'Dr. Budi', 'password' => Hash::make('dokter123'), 'role' => 'dokter']
        );

        $pasienUser = User::updateOrCreate(
            ['email' => 'pasien@example.com'],
            ['name' => 'Andi Pasien', 'password' => Hash::make('pasien123'), 'role' => 'pasien']
        );

        $pasien = Pasien::updateOrCreate(
            ['nama' => 'Andi'],
            ['user_id' => $pasienUser->id]
        );

        $obats = [
            ['nama_obat' => 'Paracetamol 500mg', 'harga' => 10000, 'stok' => 50],
            ['nama_obat' => 'Amoxicillin 500mg', 'harga' => 25000, 'stok' => 30],
            ['nama_obat' => 'Vitamin C 500mg', 'harga' => 15000, 'stok' => 40],
            ['nama_obat' => 'Ibuprofen 200mg', 'harga' => 20000, 'stok' => 20],
        ];
        foreach ($obats as $o) {
            Obat::updateOrCreate(['nama_obat' => $o['nama_obat']], ['harga' => $o['harga'], 'stok' => $o['stok']]);
        }

        $poliUmum = Poli::updateOrCreate(['nama_poli' => 'Umum']);
        $poliGigi = Poli::updateOrCreate(['nama_poli' => 'Gigi']);

        JadwalPeriksa::updateOrCreate(
            ['dokter_id' => $dokter->id, 'poli_id' => $poliUmum->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00']
        );
        JadwalPeriksa::updateOrCreate(
            ['dokter_id' => $dokter->id, 'poli_id' => $poliGigi->id, 'hari' => 'Rabu', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00']
        );
    }
}
