<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KomponenIndikatorKinerja extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'komponen_indikator_kinerjas';

    protected $fillable = [
        'id',
        'nama_indikator_kinerja',
        'bobot',
        'urutan',
        'type_indikator',
    ];

    public function subkomponenIndikatorKinerjas()
    {
        return $this->hasMany(SubkomponenIndikatorKinerja::class);
    }
}
