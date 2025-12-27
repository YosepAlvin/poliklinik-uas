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

        $daftars = DaftarPoli::with(['pasien', 'jadwalPeriksa.poli'])
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->where('status', '!=', 'selesai')
            ->orderBy('jadwal_periksa_id')
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
            'obat_json' => ['required', 'string'], // format: [{"id": 1, "jumlah": 2}, ...]
        ]);

        $dokterId = Auth::id();

        $daftar = DaftarPoli::with('jadwalPeriksa')
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->findOrFail($validated['daftar_poli_id']);

        $items = json_decode($validated['obat_json'], true) ?: [];
        
        // Membangun map id => jumlah untuk memudahkan akses
        $obatMap = [];
        foreach ($items as $item) {
            $id = is_array($item) ? ($item['id'] ?? null) : $item;
            $jumlah = is_array($item) ? ($item['jumlah'] ?? 1) : 1;
            if ($id) {
                $obatMap[$id] = ($obatMap[$id] ?? 0) + $jumlah;
            }
        }

        $ids = array_keys($obatMap);
        $biayaAdmin = 150000;
        $notifPesan = [];

        try {
            DB::transaction(function () use ($daftar, $validated, $obatMap, $ids, $biayaAdmin, &$notifPesan) {
                $obats = Obat::whereIn('id', $ids)->lockForUpdate()->get();
                $totalObat = 0;

                // Validasi stok dan hitung total
                foreach ($obats as $obat) {
                    $jumlahDiminta = $obatMap[$obat->id];
                    
                    if ($obat->stok < $jumlahDiminta) {
                        throw new \RuntimeException("Stok obat {$obat->nama_obat} tidak mencukupi (Tersedia: {$obat->stok})");
                    }
                    
                    $totalObat += ($obat->harga * $jumlahDiminta);
                }

                $periksa = Periksa::create([
                    'daftar_poli_id' => $daftar->id,
                    'tgl_periksa' => now(),
                    'catatan' => $validated['catatan'],
                    'biaya' => $totalObat + $biayaAdmin,
                ]);

                // Update status di daftar_poli
                $daftar->update(['status' => 'selesai']);

                foreach ($obats as $obat) {
                    $jumlahDiminta = $obatMap[$obat->id];
                    
                    DetailPeriksa::create([
                        'periksa_id' => $periksa->id,
                        'obat_id' => $obat->id,
                        'jumlah' => $jumlahDiminta,
                        'harga_saat_periksa' => $obat->harga,
                    ]);

                    $obat->decrement('stok', $jumlahDiminta);
                    $notifPesan[] = "{$obat->nama_obat} berkurang {$jumlahDiminta} stok";
                }
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['obat' => $e->getMessage()])->withInput();
        }

        $successMessage = 'Pemeriksaan berhasil disimpan. ' . implode(', ', $notifPesan);
        return redirect()->route('dokter.periksa.index')->with('success', $successMessage);
    }
}
