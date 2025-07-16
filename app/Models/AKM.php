<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AKM extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'akm';

    protected $fillable = [
        'id',
        'nim',
        'nama',
        'idperiode',
        'statusmhs',
        'nip',
        'dosenpa',
        'ips',
        'ipk',
        'skssemester',
        'skstotal',
        'ipklulus',
        'skslulus',
        'batassks',
        'skstempuh',
        'semmhs',
        'tglsk',
        'nosk'
    ];

    // Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
