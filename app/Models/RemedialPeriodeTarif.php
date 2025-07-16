<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialPeriodeTarif extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_periode_tarif';

    protected $fillable = [
        'id',
        'remedial_periode_id',
        'periode_angkatan',
        'tarif',
    ];

    // remdialperiode
    public function remedialperiode()
    {
        return $this->belongsTo(RemedialPeriode::class, 'remedial_periode_id', 'id');
    }
}
