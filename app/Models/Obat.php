<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'harga',
        'stok',
    ];

    public function detailPeriksas(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'obat_id');
    }
}
