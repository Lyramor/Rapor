<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SoalKuesionerSDM extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_soal_kuesionerSDM';

    protected $fillable = [
        'id',
        'kuesioner_sdm_id',
        'soal_id',
        'unsur_penilaian_id',
    ];

    public function kuesionerSDM()
    {
        return $this->belongsTo(KuesionerSDM::class, 'kuesioner_sdm_id', 'id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }

    public function unsurPenilaian()
    {
        return $this->belongsTo(UnsurPenilaian::class, 'unsur_penilaian_id', 'id');
    }
}
