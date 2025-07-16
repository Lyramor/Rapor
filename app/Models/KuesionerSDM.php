<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuesionerSDM extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_sdm';
    protected $appends = ['is_soal'];

    protected $fillable = [
        'id',
        'kode_periode',
        'nama_kuesioner',
        'subjek_penilaian',
        'jenis_kuesioner',
        // 'jadwal_kegiatan',
        'jadwal_kegiatan_mulai',
        'jadwal_kegiatan_selesai',
        'nilai_akhir'
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'kode_periode', 'kode_periode');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'subjek_penilaian', 'nip');
    }

    public function soalKuisionerSDM()
    {
        return $this->hasMany(SoalKuesionerSDM::class, 'kuesioner_sdm_id', 'id');
    }

    public function soal()
    {
        return $this->belongsToMany(Soal::class, 'kuesioner_soal_kuesionerSDM', 'kuesioner_sdm_id', 'soal_id');
    }

    // Accessor untuk mengambil jumlah pertanyaan
    public function getIsSoalAttribute()
    {
        return $this->soalKuisionerSDM->count();
    }

    // penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'kuesioner_sdm_id', 'id');
    }
}
