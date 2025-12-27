<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('pasien')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $polis = \App\Models\Poli::all();
        return view('admin.users.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,dokter,pasien',
            'status' => 'required|in:aktif,nonaktif',
            'avatar' => 'nullable|image|mimes:jpeg,png|max:2048',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'poli_id' => 'nullable|required_if:role,dokter|exists:poli,id',
            'is_jaga' => 'nullable|boolean',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        // Password hashing is handled by User model cast
        $user = User::create($validated);
        
        // Ensure no_hp is handled based on role
        if ($user->role === 'pasien') {
            \App\Models\Pasien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $user->name,
                    'no_hp' => $request->no_hp, // Use request directly since it's not in user fillable anymore
                    'no_rm' => $this->generateNoRM(), // Ensure No RM is generated
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    private function generateNoRM()
    {
        $lastPasien = \App\Models\Pasien::orderBy('no_rm', 'desc')->first();
        if (!$lastPasien) return '00000001';
        
        $lastNumber = (int)$lastPasien->no_rm;
        return str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
    }

    public function edit(User $user)
    {
        $polis = \App\Models\Poli::all();
        return view('admin.users.edit', compact('user', 'polis'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,dokter,pasien',
            'status' => 'required|in:aktif,nonaktif',
            'avatar' => 'nullable|image|mimes:jpeg,png|max:2048',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'poli_id' => 'nullable|required_if:role,dokter|exists:poli,id',
            'is_jaga' => 'nullable|boolean',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);
        
        // Sync with pasien table if role is pasien
        if ($user->role === 'pasien') {
            \App\Models\Pasien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $user->name,
                    'no_hp' => $request->no_hp,
                    // no_rm is not updated as per requirements
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak boleh menghapus diri sendiri.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Password user berhasil di-reset.');
    }
}
