<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SisipanPeriodeTarif extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_periode_tarif';

    protected $fillable = [
        'id',
        'sisipan_periode_id',
        'periode_angkatan',
        'tarif',
    ];

    // sisipanperiode
    public function sisipanperiode()
    {
        return $this->belongsTo(SisipanPeriode::class, 'sisipan_periode_id', 'id');
    }
}
