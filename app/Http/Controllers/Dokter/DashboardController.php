<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        // Hitung pasien yang sedang menunggu periksa
        $pasienMenunggu = DaftarPoli::whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
            $q->where('dokter_id', $dokterId);
        })->whereDoesntHave('periksa')->count();

        // Hitung total pasien yang sudah diperiksa oleh dokter ini
        $totalDiperiksa = Periksa::whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
            $q->where('dokter_id', $dokterId);
        })->count();

        return view('dokter.dashboard', compact('pasienMenunggu', 'totalDiperiksa'));
    }
}
