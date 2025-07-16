<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SisipanPeriodeProdi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_periode_prodi';

    protected $fillable = [
        'id',
        'sisipan_periode_id',
        'unit_kerja_id',
        'nilai_batas',
        'presensi_batas',
        'batas_sks',
    ];

    public function sisipanPeriode()
    {
        return $this->belongsTo(SisipanPeriode::class, 'sisipan_periode_id');
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
}
