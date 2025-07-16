<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialPeriodeProdi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_periode_prodi';

    protected $fillable = [
        'id',
        'remedial_periode_id',
        'unit_kerja_id',
        'nilai_batas',
        'presensi_batas',
    ];

    public function remedialPeriode()
    {
        return $this->belongsTo(RemedialPeriode::class, 'remedial_periode_id');
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
}
