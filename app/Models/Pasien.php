<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'user_id',
    ];

    public function daftarPolis(): HasMany
    {
        return $this->hasMany(DaftarPoli::class, 'pasien_id');
    }
}

