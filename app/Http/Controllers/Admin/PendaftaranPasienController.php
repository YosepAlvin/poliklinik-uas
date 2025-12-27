<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendaftaranPasienController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        $pendaftarans = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.pendaftaran.index', compact('polis', 'pendaftarans'));
    }

    public function getDokterByPoli($poliId)
    {
        $dokters = User::where('role', 'dokter')
            ->where('poli_id', $poliId)
            ->where('status', 'aktif')
            ->get(['id', 'name', 'is_jaga']);
        return response()->json($dokters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'poli_id' => 'required|exists:poli,id',
            'dokter_id' => 'required|exists:users,id',
            'tanggal_periksa' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // 1. Check or Create Pasien
            $pasien = Pasien::where('nama', $validated['nama'])
                ->where('tgl_lahir', $validated['tgl_lahir'])
                ->first();

            if (!$pasien) {
                $pasien = Pasien::create([
                    'no_rm' => $this->generateNoRM(),
                    'nama' => $validated['nama'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                ]);
            }

            // 2. Logic Dokter Jaga (Fallback)
            $tanggal = Carbon::parse($validated['tanggal_periksa']);
            $hariInggris = $tanggal->format('l');
            $hariIndo = $this->translateHari($hariInggris);

            $jadwal = JadwalPeriksa::where('dokter_id', $validated['dokter_id'])
                ->where('hari', $hariIndo)
                ->where('aktif', true)
                ->first();

            $finalDokterId = $validated['dokter_id'];
            $finalJadwalId = $jadwal ? $jadwal->id : null;

            if (!$jadwal) {
                // Fallback ke Dokter Jaga (UGD) 
                // Jika pendaftaran hari ini, cari yang shiftnya sesuai jam sekarang
                // Jika pendaftaran hari depan, ambil shift pagi (default)
                $isToday = $tanggal->isToday();
                $currentTime = now()->format('H:i');
                
                $queryJaga = User::where('role', 'dokter')
                    ->where('is_jaga', true)
                    ->where('status', 'aktif');

                $dokterJagas = $queryJaga->get();
                
                foreach ($dokterJagas as $dj) {
                    $jj = JadwalPeriksa::where('dokter_id', $dj->id)
                        ->where('hari', $hariIndo)
                        ->where('aktif', true)
                        ->get();
                    
                    foreach ($jj as $shift) {
                        if ($isToday) {
                            // Cek apakah jam sekarang masuk dalam shift ini
                            // Handle shift malam (e.g. 16:00 - 00:00)
                            $start = $shift->jam_mulai;
                            $end = $shift->jam_selesai == '00:00' ? '23:59' : $shift->jam_selesai;
                            
                            if ($currentTime >= $start && $currentTime <= $end) {
                                $finalDokterId = $dj->id;
                                $finalJadwalId = $shift->id;
                                break 2;
                            }
                        } else {
                            // Untuk hari depan, ambil shift pertama yang ketemu
                            $finalDokterId = $dj->id;
                            $finalJadwalId = $shift->id;
                            break 2;
                        }
                    }
                }

                // Jika masih belum ketemu (misal tidak ada jadwal jaga di hari itu sama sekali), 
                // ambil jadwal jaga apa saja yang tersedia sebagai fallback terakhir
                if (!$finalJadwalId) {
                    $fallbackJaga = JadwalPeriksa::whereHas('dokter', function($q) {
                        $q->where('is_jaga', true)->where('status', 'aktif');
                    })->where('hari', $hariIndo)->first();

                    if ($fallbackJaga) {
                        $finalDokterId = $fallbackJaga->dokter_id;
                        $finalJadwalId = $fallbackJaga->id;
                    }
                }
            }

            if (!$finalJadwalId) {
                return redirect()->back()->withErrors(['dokter_id' => 'Dokter terpilih tidak praktek dan tidak ada Dokter Jaga yang tersedia pada hari tersebut.'])->withInput();
            }

            // 3. Antrian Otomatis
            $noAntrian = $this->generateNoAntrian($finalJadwalId, $validated['tanggal_periksa']);

            // 4. Daftar Poli
            DaftarPoli::create([
                'pasien_id' => $pasien->id,
                'jadwal_periksa_id' => $finalJadwalId,
                'tanggal_periksa' => $validated['tanggal_periksa'],
                'keluhan' => $validated['keluhan'],
                'no_antrian' => $noAntrian,
                'status' => 'menunggu',
            ]);

            $message = "Pendaftaran berhasil.";
            if ($finalDokterId != $validated['dokter_id']) {
                $namaJaga = User::find($finalDokterId)->name;
                $message .= " Dialihkan ke Dokter Jaga: $namaJaga karena dokter utama tidak praktik.";
            }

            return redirect()->route('admin.pendaftaran.index')->with('success', $message);
        });
    }

    private function generateNoRM()
    {
        $lastPasien = Pasien::orderBy('no_rm', 'desc')->first();
        if (!$lastPasien) return Carbon::now()->format('Ym') . '-001';
        
        $lastNoRM = $lastPasien->no_rm;
        $parts = explode('-', $lastNoRM);
        $number = isset($parts[1]) ? (int)$parts[1] : 0;
        
        return Carbon::now()->format('Ym') . '-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
    }

    private function generateNoAntrian($jadwalId, $tanggal)
    {
        $maxAntrian = DaftarPoli::where('jadwal_periksa_id', $jadwalId)
            ->whereDate('tanggal_periksa', $tanggal)
            ->max('no_antrian');
        
        return ($maxAntrian ?? 0) + 1;
    }

    private function translateHari($hari)
    {
        $map = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        return $map[$hari] ?? $hari;
    }
}
