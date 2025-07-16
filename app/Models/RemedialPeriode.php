<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RemedialPeriode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_periode';

    protected $fillable = [
        'id',
        'unit_kerja_id',
        'kode_periode',
        'nama_periode',
        'format_va',
        'add_nrp',
        'tanggal_mulai',
        'tanggal_selesai',
        'nilai_batas',
        'is_aktif',
    ];

    // periode
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'kode_periode', 'kode_periode');
    }

    // remedialperiode tarif
    public function remedialperiodetarif()
    {
        return $this->hasMany(RemedialPeriodeTarif::class);
    }

    // remedialperiode prodi
    public function remedialperiodeprodi()
    {
        return $this->hasMany(RemedialPeriodeProdi::class);
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
}
