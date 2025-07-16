<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PresensiKuliah extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'presensi_kuliah';

    protected $fillable = [
        'id',
        'periodeakademik',
        'programstudi',
        'tahunkurikulum',
        'kodemk',
        'matakuliah',
        'kelas',
        'sistemkuliah',
        'kelasmahasiswa',
        'pertemuanke',
        'tanggal',
        'hari',
        'waktumengajar',
        'jenisjadwal',
        'statusperkuliahan',
        'presensi',
        'nama',
        'nim',
    ];
}
