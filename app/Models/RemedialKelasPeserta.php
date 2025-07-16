<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialKelasPeserta extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_kelas_peserta';

    protected $fillable = [
        'id',
        'remedial_kelas_id',
        'nim',
        'nnumerik',
        'nhuruf',
    ];

    public function remedialKelas()
    {
        return $this->belongsTo(RemedialKelas::class, 'remedial_kelas_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
