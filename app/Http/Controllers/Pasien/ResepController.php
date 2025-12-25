<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();
        $items = collect();
        if ($pasien) {
            $items = Periksa::with(['daftarPoli.jadwalPeriksa.dokter', 'detailPeriksas.obat'])
                ->whereHas('daftarPoli', fn($q) => $q->where('pasien_id', $pasien->id))
                ->orderByDesc('tgl_periksa')
                ->paginate(20);
        }
        return view('pasien.resep.index', compact('items'));
    }
}

