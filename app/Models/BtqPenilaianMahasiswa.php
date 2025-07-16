<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BtqPenilaianMahasiswa extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'btq_penilaian_mahasiswa';

    protected $fillable = [
        'btq_penilaian_id',
        'btq_jadwal_mahasiswa_id',
        'jenis_penilaian',
        'nilai',
        'nilai_self',
        'penguji_id',
    ];

    public function btqPenilaian()
    {
        return $this->belongsTo(BtqPenilaian::class, 'btq_penilaian_id');
    }

    public function btqJadwalMahasiswa()
    {
        return $this->belongsTo(BtqJadwalMahasiswa::class, 'btq_jadwal_mahasiswa_id');
    }

    public function btqPenilaianMahasiswa()
    {
        return $this->hasMany(BtqPenilaianMahasiswa::class, 'btq_penilaian_id');
    }
}
