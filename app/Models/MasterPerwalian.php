<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterPerwalian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_perwalian';

    protected $fillable = [
        'id_periode',
        'nim',
        'id_status_mahasiswa',
        'status_mahasiswa',
        'nip_dosen_pembimbing',
        'semester_mahasiswa',
        'ips',
        'ipk',
        'ipk_lulus',
        'sks_semester',
        'sks_total',
        'sks_lulus',
        'tanggal_validasi_krs',
        'tanggal_sk',
        'nomor_sk',
        'alasan_cuti'
    ];

    // relation with mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

}
