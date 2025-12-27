<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $items = JadwalPeriksa::with(['dokter', 'poli'])->orderBy('hari')->paginate(20);
        return view('pasien.pendaftaran.index', compact('items'));
    }

    public function create($jadwalId)
    {
        $jadwal = JadwalPeriksa::with(['dokter', 'poli'])->findOrFail($jadwalId);
        return view('pasien.pendaftaran.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jadwal_periksa_id' => ['required', 'integer', 'exists:jadwal_periksa,id'],
            'keluhan' => ['required', 'string'],
        ]);
        
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->firstOrFail();
        
        // Ambil jadwal untuk tahu hari-nya
        $jadwal = JadwalPeriksa::findOrFail($data['jadwal_periksa_id']);
        
        // Tentukan tanggal periksa (hari ini atau tanggal terdekat sesuai hari jadwal)
        // Untuk saat ini kita asumsikan pendaftaran adalah untuk hari ini atau 
        // kita cari tanggal terdekat yang sesuai dengan hari di jadwal.
        $tanggalPeriksa = $this->getNextDateForDay($jadwal->hari);
        
        $lastNo = DaftarPoli::where('jadwal_periksa_id', $data['jadwal_periksa_id'])
            ->whereDate('tanggal_periksa', $tanggalPeriksa)
            ->max('no_antrian') ?? 0;
            
        $no = $lastNo + 1;
        
        DaftarPoli::create([
            'pasien_id' => $pasien->id,
            'jadwal_periksa_id' => $data['jadwal_periksa_id'],
            'tanggal_periksa' => $tanggalPeriksa,
            'keluhan' => $data['keluhan'],
            'no_antrian' => $no,
            'status' => 'menunggu',
        ]);
        
        return redirect()->route('pasien.dashboard')->with('success', 'Pendaftaran berhasil. No Antrian: '.$no);
    }

    private function getNextDateForDay($hariIndo)
    {
        $days = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];
        
        $dayEng = $days[$hariIndo] ?? 'Monday';
        $today = now()->startOfDay();
        
        if (now()->format('l') === $dayEng) {
            return $today->format('Y-m-d');
        }
        
        return $today->modify('next ' . $dayEng)->format('Y-m-d');
    }
}

