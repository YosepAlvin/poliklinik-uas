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
        $lastNo = DaftarPoli::where('jadwal_periksa_id', $data['jadwal_periksa_id'])->max('no_antrian') ?? 0;
        $no = $lastNo + 1;
        DaftarPoli::create([
            'pasien_id' => $pasien->id,
            'jadwal_periksa_id' => $data['jadwal_periksa_id'],
            'keluhan' => $data['keluhan'],
            'no_antrian' => $no,
        ]);
        return redirect()->route('pasien.dashboard')->with('success', 'Pendaftaran berhasil. No Antrian: '.$no);
    }
}

