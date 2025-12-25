<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $q = request('q');
        $items = Poli::when($q, function($query) use ($q){
                $query->where('nama_poli', 'like', '%'.$q.'%');
            })
            ->orderBy('nama_poli')
            ->paginate(20);
        return view('admin.poli.index', compact('items'));
    }

    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_poli' => ['required', 'string', 'unique:poli,nama_poli'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);
        Poli::create($data);
        return redirect()->route('admin.poli.index')->with('success', 'Poli dibuat');
    }

    public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $data = $request->validate([
            'nama_poli' => ['required', 'string', 'unique:poli,nama_poli,'.$poli->id],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);
        $poli->update($data);
        return redirect()->route('admin.poli.index')->with('success', 'Poli diubah');
    }

    public function destroy(Poli $poli)
    {
        if ($poli->jadwalPeriksas()->exists()) {
            return redirect()->route('admin.poli.index')->withErrors([
                'error' => 'Poli tidak bisa dihapus karena masih digunakan pada jadwal.',
            ]);
        }
        $poli->delete();
        return redirect()->route('admin.poli.index')->with('success', 'Poli dihapus');
    }
}
