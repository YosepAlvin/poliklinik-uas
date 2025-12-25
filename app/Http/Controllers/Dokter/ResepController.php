<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();
        $items = Periksa::with(['daftarPoli.pasien', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli.jadwalPeriksa', fn($q) => $q->where('dokter_id', $dokterId))
            ->orderByDesc('tgl_periksa')
            ->paginate(20);
        return view('dokter.resep.index', compact('items'));
    }
}

