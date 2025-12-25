<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftars = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->whereDoesntHave('periksa')
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftars'));
    }

    public function create($id)
    {
        $dokterId = Auth::id();
        $daftar = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->findOrFail($id);

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa-pasien.create', compact('daftar', 'obats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'daftar_poli_id' => ['required', 'integer', 'exists:daftar_poli,id'],
            'catatan' => ['required', 'string'],
            'obat_json' => ['required', 'string'],
        ]);

        $dokterId = Auth::id();

        $daftar = DaftarPoli::with('jadwalPeriksa')
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->findOrFail($validated['daftar_poli_id']);

        $items = json_decode($validated['obat_json'], true) ?: [];
        $ids = collect($items)->map(function ($item) {
            if (is_array($item) && array_key_exists('id', $item)) {
                return (int) $item['id'];
            }
            return (int) $item;
        })->filter()->values();

        $obats = collect();
        $totalObat = 0;
        $biayaAdmin = 150000;
        $total = 0;

        try {
        DB::transaction(function () use ($daftar, $validated, &$obats, &$totalObat, $biayaAdmin, &$total, $ids) {
            $obats = Obat::whereIn('id', $ids)->lockForUpdate()->get();
            // Validasi stok
            foreach ($obats as $obat) {
                if (($obat->stok ?? 0) <= 0) {
                    throw new \RuntimeException("Stok obat {$obat->nama_obat} habis");
                }
            }
            $totalObat = $obats->sum('harga');
            $total = $totalObat + $biayaAdmin;

            $periksa = Periksa::create([
                'daftar_poli_id' => $daftar->id,
                'tgl_periksa' => now(),
                'catatan' => $validated['catatan'],
                'biaya' => $total,
            ]);

            foreach ($obats as $obat) {
                DetailPeriksa::create([
                    'periksa_id' => $periksa->id,
                    'obat_id' => $obat->id,
                    'harga' => $obat->harga,
                ]);
                $obat->decrement('stok', 1);
            }
        });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['obat' => $e->getMessage()])->withInput();
        }

        return redirect()->route('dokter.periksa.index')->with('success', 'Pemeriksaan berhasil disimpan');
    }
}
