<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisipanKelasPeserta extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_kelas_peserta';

    protected $fillable = [
        'id',
        'sisipan_kelas_id',
        'nim',
        'nnumerik',
        'nhuruf',
    ];

    public function sisipanKelas()
    {
        return $this->belongsTo(SisipanKelas::class, 'sisipan_kelas_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
