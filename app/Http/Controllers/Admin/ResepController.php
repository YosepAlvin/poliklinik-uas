<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periksa;

class ResepController extends Controller
{
    public function index()
    {
        $items = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter', 'detailPeriksas.obat'])
            ->orderByDesc('tgl_periksa')
            ->paginate(20);
        return view('admin.resep.index', compact('items'));
    }
}

