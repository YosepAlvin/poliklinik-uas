<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'alamat',
        'tgl_lahir',
        'no_rm',
        'user_id',
        'jenis_kelamin',
        'no_hp',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function getUmurAttribute()
    {
        if (!$this->tgl_lahir) return '-';
        return $this->tgl_lahir->age . ' Tahun';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function daftarPolis(): HasMany
    {
        return $this->hasMany(DaftarPoli::class, 'pasien_id');
    }

    public function periksas()
    {
        return $this->hasManyThrough(Periksa::class, DaftarPoli::class, 'pasien_id', 'daftar_poli_id');
    }
}

