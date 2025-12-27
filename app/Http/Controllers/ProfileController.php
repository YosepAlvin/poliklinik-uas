<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $pasien = $user->role === 'pasien' ? $user->pasien : null;
        $polis = \App\Models\Poli::all();
        return view('profile.index', compact('user', 'pasien', 'polis'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $rules = [
            'avatar' => 'nullable|image|mimes:jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($user->role === 'pasien') {
            $rules['nama_medis'] = 'required|string|max:255';
            $rules['alamat'] = 'nullable|string|max:255';
            $rules['no_hp'] = 'nullable|string|max:20';
            $rules['tgl_lahir'] = 'nullable|date';
            $rules['jenis_kelamin'] = 'nullable|in:L,P';
        } elseif ($user->role === 'dokter') {
            $rules['no_hp'] = 'nullable|string|max:20';
            $rules['poli_id'] = 'required|exists:poli,id';
            $rules['alamat'] = 'nullable|string|max:255';
            $rules['jenis_kelamin'] = 'nullable|in:L,P';
            $rules['tgl_lahir'] = 'nullable|date';
        } else {
            $rules['no_hp'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        if ($user->role === 'dokter') {
            $user->poli_id = $validated['poli_id'];
            $user->no_hp = $validated['no_hp'] ?? $user->no_hp;
            $user->alamat = $validated['alamat'] ?? $user->alamat;
            $user->jenis_kelamin = $validated['jenis_kelamin'] ?? $user->jenis_kelamin;
            $user->tgl_lahir = $validated['tgl_lahir'] ?? $user->tgl_lahir;
        }

        $user->save();

        // Sync with pasien table if role is pasien
        if ($user->role === 'pasien') {
            $pasienData = [
                'nama' => $validated['nama_medis'],
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'tgl_lahir' => $validated['tgl_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ];

            \App\Models\Pasien::updateOrCreate(
                ['user_id' => $user->id],
                $pasienData
            );
        }

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }
}
