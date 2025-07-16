<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SisipanKelas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_kelas';

    protected $fillable = [
        'id',
        'sisipan_periode_id',
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

    //sisipanperiode
    public function sisipanperiode()
    {
        return $this->belongsTo(SisipanPeriode::class, 'sisipan_periode_id', 'id');
    }

    // matakuliah ke sisipan ajuan detail
    public function matakuliah()
    {
        return $this->belongsTo(SisipanAjuanDetail::class, 'kodemk', 'idmk');
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
        return $this->hasMany(SisipanKelasPeserta::class, 'sisipan_kelas_id', 'id');
    }
}
