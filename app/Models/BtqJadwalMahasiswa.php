<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BtqJadwalMahasiswa extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'btq_jadwal_mahasiswa';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'jadwal_id',
        'mahasiswa_id',
        'presensi',
        'nilai_bacaan',
        'nilai_tulisan',
        'nilai_hafalan',
        'lampiran',
        'is_change',
    ];

    // Relasi ke tabel 'btq_jadwal'
    public function jadwal()
    {
        return $this->belongsTo(BtqJadwal::class, 'jadwal_id', 'id');
    }

    // Relasi ke tabel 'mahasiswa'
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'nim');
    }

    // Relasi ke tabel 'btq_penilaian_mahasiswa'
    public function penilaian()
    {
        return $this->hasMany(BtqPenilaianMahasiswa::class, 'btq_jadwal_mahasiswa_id', 'id');
    }

    // Accessor untuk nilai bacaan
    public function getNilaiBacaanAttribute()
    {
        return $this->penilaian()
            ->where('jenis_penilaian', 'Bacaan')
            ->sum('nilai');
    }

    // Accessor untuk nilai tulisan
    public function getNilaiTulisanAttribute()
    {
        return $this->penilaian()
            ->where('jenis_penilaian', 'Tulisan')
            ->sum('nilai');
    }

    // Accessor untuk nilai hafalan
    public function getNilaiHafalanAttribute()
    {
        return $this->penilaian()
            ->where('jenis_penilaian', 'Hafalan')
            ->sum('nilai');
    }
}
