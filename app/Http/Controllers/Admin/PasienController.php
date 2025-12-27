<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $items = Pasien::with('user')->orderBy('nama')->paginate(20);
        return view('admin.pasien.index', compact('items'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'tgl_lahir' => ['nullable', 'date'],
            'no_rm' => ['nullable', 'string', 'unique:pasien,no_rm'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
        ]);
        Pasien::create($data);
        return redirect()->route('admin.pasien.index')->with('success', 'Pasien dibuat');
    }

    public function riwayat(Pasien $pasien)
    {
        $periksas = $pasien->periksas()
            ->with(['daftarPoli.jadwalPeriksa.dokter', 'detailPeriksas.obat'])
            ->orderByDesc('tgl_periksa')
            ->paginate(10);
        return view('admin.pasien.riwayat', compact('pasien', 'periksas'));
    }

    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $data = $request->validate([
            'nama' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'tgl_lahir' => ['nullable', 'date'],
            'no_rm' => ['nullable', 'string', "unique:pasien,no_rm,{$pasien->id}"],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
        ]);
        $pasien->update($data);
        return redirect()->route('admin.pasien.index')->with('success', 'Pasien diubah');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('admin.pasien.index')->with('success', 'Pasien dihapus');
    }
}

