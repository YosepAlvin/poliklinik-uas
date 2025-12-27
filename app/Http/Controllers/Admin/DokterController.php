<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $items = User::with('poli')->where('role', 'dokter')->orderBy('name')->paginate(20);
        return view('admin.dokter.index', compact('items'));
    }

    public function create()
    {
        $polis = \App\Models\Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'poli_id' => ['required', 'exists:poli,id'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tgl_lahir' => ['nullable', 'date'],
            'is_jaga' => ['nullable', 'boolean'],
        ]);
        $data['role'] = 'dokter';
        User::create($data);
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter dibuat');
    }

    public function edit(User $dokter)
    {
        $polis = \App\Models\Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.$dokter->id],
            'password' => ['nullable', 'string', 'min:6'],
            'poli_id' => ['required', 'exists:poli,id'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tgl_lahir' => ['nullable', 'date'],
            'is_jaga' => ['nullable', 'boolean'],
        ]);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $dokter->update($data);
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter diubah');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter dihapus');
    }
}

