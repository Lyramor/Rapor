<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SisipanPeriode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_periode';

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

    // sisipanperiode tarif
    public function sisipanperiodetarif()
    {
        return $this->hasMany(SisipanPeriodeTarif::class);
    }

    // remedialperiode prodi
    public function sisipanperiodeprodi()
    {
        return $this->hasMany(SisipanPeriodeProdi::class);
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
}
