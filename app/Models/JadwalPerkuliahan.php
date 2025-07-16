<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JadwalPerkuliahan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_perkuliahan';

    protected $fillable = [
        'programstudi',
        'kodemk',
        'matakuliah',
        'kurikulum',
        'periode',
        'kelas',
        'sks',
        'sistemkuliah',
        'kapasitas',
        'jumlahpesertakelas',
        'pertemuan',
        'tanggal',
        'hari',
        'waktumulai',
        'waktuselesai',
        'ruang',
        'metodepembelajaran',
        'jenispertemuan',
        'nidn',
        'nip',
        'dosenpengajar',
        'statuspengajaran',
        'realisasimateri',
        'rencanamateri',
        'lokasi',
        'kelasid',
        'lastupdate',
        'jadwalid',
        'lastinsert',
    ];
}
