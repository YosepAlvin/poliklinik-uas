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
        $items = User::where('role', 'dokter')->orderBy('name')->paginate(20);
        return view('admin.dokter.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'dokter';
        User::create($data);
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter dibuat');
    }

    public function edit(User $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, User $dokter)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.$dokter->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
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

