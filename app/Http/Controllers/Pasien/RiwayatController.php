<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();
        $items = collect();
        if ($pasien) {
            $items = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter'])
                ->whereHas('daftarPoli', fn($q) => $q->where('pasien_id', $pasien->id))
                ->orderByDesc('tgl_periksa')
                ->paginate(20);
        }
        return view('pasien.riwayat.index', compact('items'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->firstOrFail();
        $periksa = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli', fn($q) => $q->where('pasien_id', $pasien->id))
            ->findOrFail($id);
        return view('pasien.riwayat.show', compact('periksa'));
    }
}

