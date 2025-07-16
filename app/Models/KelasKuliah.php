<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasKuliah extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kelas_kuliah';

    protected $fillable = [
        'id',
        'periodeakademik',
        'programstudi',
        'kurikulum',
        'kodemk',
        'namamk',
        'namakelas',
        'sistemkuliah',
        'namakelasmahasiswa',
        'kapasitas',
        'tanggalmulai',
        'tanggalselesai',
        'jumlahpertemuan',
        'mbkm',
        'hari',
        'jammulai',
        'jamselesai',
        'jenispertemuan',
        'metodepembelajaran',
        'namaruang',
        'nip',
        'namadosen',
        'kelasid',
    ];

    //jadwal perkuliahan
    public function jadwalPerkuliahan()
    {
        return $this->hasMany(JadwalPerkuliahan::class, 'kelasid', 'kelasid');
    }

    public function scopeWithNamaKelas($query, $namakelas)
    {
        return $query->where('namakelas', $namakelas);
    }

    public function scopeWithPeriodeAkademik($query, $periodeakademik)
    {
        return $query->where('periodeakademik', $periodeakademik);
    }

    // remedialAjuanDetail
    public function remedialAjuanDetail()
    {
        return $this->hasMany(RemedialAjuanDetail::class, 'idmk', 'kodemk');
    }
}
