<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'id',
        'agama',
        'alamat',
        'email',
        'emailkampus',
        'gelombang',
        'jalurpendaftaran',
        'jeniskelamin',
        'kelasperkuliahan',
        'konsentrasi',
        'nama',
        'namaibu',
        'nik',
        'nim',
        'nohp',
        'periodemasuk',
        'programstudi',
        'sistemkuliah',
        'statusmahasiswa',
        'tanggallahir',
        'tempatlahir'
    ];

    // has many AKM
    public function akm()
    {
        return $this->hasMany(AKM::class, 'nim', 'nim');
    }

    //user
    public function user()
    {
        return $this->hasOne(User::class, 'key_relation', 'nim');
    }

    // perwalian
    public function perwalian()
    {
        return $this->hasMany(MasterPerwalian::class, 'nim', 'nim');
    }

    // invoice
    public function invoice()
    {
        return $this->hasMany(MasterInvoice::class, 'nim', 'nim');
    }
}
