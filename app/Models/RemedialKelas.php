<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RemedialKelas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_kelas';

    protected $fillable = [
        'id',
        'remedial_periode_id',
        'programstudi',
        'kodemk',
        'nip',
        'kode_edlink',
        'catatan'
    ];

    //append jumlah peserta
    protected $appends = ['jumlahpeserta'];

    public function getJumlahpesertaAttribute()
    {
        return $this->peserta->count();
    }

    //remedialperiode
    public function remedialperiode()
    {
        return $this->belongsTo(RemedialPeriode::class, 'remedial_periode_id', 'id');
    }

    // matakuliah ke remedial ajuan detail
    public function matakuliah()
    {
        return $this->belongsTo(RemedialAjuanDetail::class, 'kodemk', 'idmk');
    }

    // kelaskuliah
    public function kelaskuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'kodemk', 'kodemk');
    }

    // nama dosen
    public function dosen()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    // peserta
    public function peserta()
    {
        return $this->hasMany(RemedialKelasPeserta::class, 'remedial_kelas_id', 'id');
    }
}
