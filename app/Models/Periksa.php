<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periksa extends Model
{
    protected $table = 'periksa';

    protected $fillable = [
        'daftar_poli_id',
        'tgl_periksa',
        'catatan',
        'biaya',
    ];

    protected $casts = [
        'tgl_periksa' => 'datetime',
    ];

    public function daftarPoli(): BelongsTo
    {
        return $this->belongsTo(DaftarPoli::class, 'daftar_poli_id');
    }

    public function detailPeriksas(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'periksa_id');
    }
}

