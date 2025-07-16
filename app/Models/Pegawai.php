<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pegawai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nik',
        'npwp',
        'golpangkat',
        'jabatanfungsional',
        'jenispegawai',
        'jeniskelamin',
        'agama',
        'tempatlahir',
        'tanggallahir',
        'email',
        'nohp',
        'alamat',
        'jabatanstruktural',
        'pendidikanterakhir',
        'unit_kerja_id',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nip', 'nip');
    }

    // user
    public function user()
    {
        return $this->hasOne(User::class, 'key_relation', 'nip');
    }
}
