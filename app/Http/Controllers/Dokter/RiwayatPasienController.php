<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $riwayat = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter',
                'detailPeriksas.obat',
            ])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->orderByDesc('tgl_periksa')
            ->get();

        return view('dokter.riwayat-pasien.index', compact('riwayat'));
    }

    public function show($id)
    {
        $dokterId = Auth::id();

        $periksa = Periksa::with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter',
                'detailPeriksas.obat',
            ])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->findOrFail($id);

        return view('dokter.riwayat-pasien.show', compact('periksa'));
    }
}

