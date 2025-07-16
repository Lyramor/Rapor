<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pertanyaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_pertanyaan';

    protected $fillable = [
        'id',
        'no_pertanyaan',
        'jenis_pertanyaan',
        'pertanyaan',
        'scale_range_min',
        'scale_range_max',
        'scale_text_min',
        'scale_text_max',
        'soal_id',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
