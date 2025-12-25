<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $items = JadwalPeriksa::with('poli')->where('dokter_id', Auth::id())->orderBy('hari')->paginate(20);
        return view('dokter.jadwal.index', compact('items'));
    }

    public function create()
    {
        $polis = Poli::orderBy('nama_poli')->get();
        return view('dokter.jadwal.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'poli_id' => ['required', 'integer', 'exists:poli,id'],
            'hari' => ['required', 'string'],
            'jam_mulai' => ['required', 'string'],
            'jam_selesai' => ['required', 'string'],
        ]);
        $data['dokter_id'] = Auth::id();
        JadwalPeriksa::create($data);
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal dibuat');
    }

    public function edit(JadwalPeriksa $jadwal)
    {
        $this->authorizeJadwal($jadwal);
        $polis = Poli::orderBy('nama_poli')->get();
        return view('dokter.jadwal.edit', compact('jadwal', 'polis'));
    }

    public function update(Request $request, JadwalPeriksa $jadwal)
    {
        $this->authorizeJadwal($jadwal);
        $data = $request->validate([
            'poli_id' => ['required', 'integer', 'exists:poli,id'],
            'hari' => ['required', 'string'],
            'jam_mulai' => ['required', 'string'],
            'jam_selesai' => ['required', 'string'],
        ]);
        $jadwal->update($data);
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal diubah');
    }

    public function destroy(JadwalPeriksa $jadwal)
    {
        $this->authorizeJadwal($jadwal);
        $jadwal->delete();
        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal dihapus');
    }

    protected function authorizeJadwal(JadwalPeriksa $jadwal): void
    {
        abort_if($jadwal->dokter_id !== Auth::id(), 403);
    }
}
