<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
        'status',
    ];

    public function jadwalPeriksas(): HasMany
    {
        return $this->hasMany(JadwalPeriksa::class, 'poli_id');
    }
}
