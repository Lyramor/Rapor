<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BtqJadwal extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'btq_jadwal';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'kode_periode',
        'penguji_id',
        'kuota',
        'hari',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'deskripsi',
        'peserta',
        'is_active',
    ];

    // Tipe data casting untuk beberapa kolom
    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    protected $appends = ['jumlah_peserta', 'jumlah_peserta_hadir'];

    // Relasi ke tabel 'users'
    public function penguji()
    {
        return $this->belongsTo(User::class, 'penguji_id', 'username');
    }

    // Relasi ke tabel 'periode'
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'kode_periode', 'kode_periode');
    }

    // Relasi ke BtqJadwalMahasiswa untuk mengetahui mahasiswa yang terdaftar
    public function mahasiswaTerdaftar()
    {
        return $this->hasMany(BtqJadwalMahasiswa::class, 'jadwal_id', 'id');
    }

    // Metode untuk menghitung jumlah mahasiswa yang terdaftar
    public function jumlahMahasiswaTerdaftar()
    {
        return $this->mahasiswaTerdaftar()->count();
    }

    public function getJumlahPesertaAttribute()
    {
        return $this->mahasiswaTerdaftar()->count();
    }

    public function jumlahPesertaHadir()
    {
        return $this->mahasiswaTerdaftar()->where('presensi', 1)->count();
    }

    public function getJumlahPesertaHadirAttribute()
    {
        return $this->mahasiswaTerdaftar()->where('presensi', 1)->count();
    }

}
