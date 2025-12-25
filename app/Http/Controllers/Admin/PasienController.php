<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $items = Pasien::orderBy('nama')->paginate(20);
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
        ]);
        Pasien::create($data);
        return redirect()->route('admin.pasien.index')->with('success', 'Pasien dibuat');
    }

    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $data = $request->validate([
            'nama' => ['required', 'string'],
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

