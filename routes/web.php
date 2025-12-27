<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ketentuan-uas', function () {
    return view('ketentuan.uas');
})->name('ketentuan.uas');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
});
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) return redirect()->route('login');
    return match ($user->role ?? null) {
        'admin' => redirect()->route('admin.dashboard'),
        'dokter' => redirect()->route('dokter.dashboard'),
        'pasien' => redirect()->route('pasien.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jadwal', \App\Http\Controllers\Dokter\JadwalPeriksaController::class)->except(['show']);
    Route::get('/resep', [\App\Http\Controllers\Dokter\ResepController::class, 'index'])->name('resep.index');
    Route::get('/periksa-pasien', [\App\Http\Controllers\Dokter\PeriksaPasienController::class, 'index'])->name('periksa.index');
    Route::get('/periksa-pasien/{id}/create', [\App\Http\Controllers\Dokter\PeriksaPasienController::class, 'create'])->name('periksa.create');
    Route::post('/periksa-pasien', [\App\Http\Controllers\Dokter\PeriksaPasienController::class, 'store'])->name('periksa.store');
    Route::get('/riwayat-pasien', [\App\Http\Controllers\Dokter\RiwayatPasienController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat-pasien/{id}', [\App\Http\Controllers\Dokter\RiwayatPasienController::class, 'show'])->name('riwayat.show');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::resource('obat', \App\Http\Controllers\Admin\ObatController::class);
    Route::resource('dokter', \App\Http\Controllers\Admin\DokterController::class);
    Route::resource('pasien', \App\Http\Controllers\Admin\PasienController::class);
    Route::get('pasien/{pasien}/riwayat', [\App\Http\Controllers\Admin\PasienController::class, 'riwayat'])->name('pasien.riwayat');
    Route::resource('poli', \App\Http\Controllers\Admin\PoliController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('resep', \App\Http\Controllers\Admin\ResepController::class);
    Route::get('/jadwal', [\App\Http\Controllers\Admin\JadwalController::class, 'index'])->name('jadwal.index');
    
    // Pendaftaran Pasien (Baru)
    Route::get('/pendaftaran', [\App\Http\Controllers\Admin\PendaftaranPasienController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [\App\Http\Controllers\Admin\PendaftaranPasienController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/get-dokter/{poliId}', [\App\Http\Controllers\Admin\PendaftaranPasienController::class, 'getDokterByPoli']);
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::view('/dashboard', 'pasien.dashboard')->name('dashboard');
    Route::get('/resep', [\App\Http\Controllers\Pasien\ResepController::class, 'index'])->name('resep.index');
    Route::get('/pendaftaran', [\App\Http\Controllers\Pasien\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}/create', [\App\Http\Controllers\Pasien\PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [\App\Http\Controllers\Pasien\PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/riwayat', [\App\Http\Controllers\Pasien\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [\App\Http\Controllers\Pasien\RiwayatController::class, 'show'])->name('riwayat.show');
    Route::view('/periksa', 'pasien.periksa.index')->name('periksa.index');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
