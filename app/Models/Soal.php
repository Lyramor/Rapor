<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Soal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_soal';
    protected $appends = ['jumlah_pertanyaan'];

    protected $fillable = [
        'id',
        'nama_soal',
        'keterangan',
        'soal_acak',
        'publik',
    ];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }

    // Accessor untuk mengambil jumlah pertanyaan
    public function getJumlahPertanyaanAttribute()
    {
        return $this->pertanyaan->count();
    }
}
