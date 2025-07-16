<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SubkomponenIndikatorKinerja extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'subkomponen_indikator_kinerjas';

    protected $fillable = [
        'id',
        'subindikator_kinerja',
        'target',
        'urutan',
        'komponen_indikator_kinerja_id',
    ];

    public function komponenIndikatorKinerja()
    {
        return $this->belongsTo(KomponenIndikatorKinerja::class);
    }
}
