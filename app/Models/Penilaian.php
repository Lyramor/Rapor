<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Penilaian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_penilaian';

    protected $fillable = [
        'id',
        'responden_id',
        'pertanyaan_id',
        'jawaban_numerik',
        'jawaban_essay',
        'kuesioner_sdm_id',
        'unsur_penilaian_id'
    ];

    public function responden()
    {
        return $this->belongsTo(Responden::class, 'responden_id', 'id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id', 'id');
    }

    // unsurpenilaian
    public function unsurPenilaian()
    {
        return $this->belongsTo(UnsurPenilaian::class, 'unsur_penilaian_id', 'id');
    }
}
