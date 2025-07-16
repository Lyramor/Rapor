<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Rapor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rapor_kinerja_v1';
    protected $appends = ['nilai_bkd', 'nilai_edom', 'nilai_edasep', 'nilai_total', 'grade'];

    protected $fillable = [
        'id',
        'periode_rapor',
        'dosen_nip',
        'programstudi',
        // 'bkd_pendidikan',
        // 'bkd_penelitian',
        // 'bkd_ppm',
        // 'bkd_penunjangan',
        // 'bkd_kewajibankhusus',
        'bkd_total',
        'edom_materipembelajaran',
        'edom_pengelolaankelas',
        'edom_prosespengajaran',
        'edom_penilaian',
        'edasep_atasan',
        'edasep_sejawat',
        'edasep_bawahan',
    ];

    //dapatkan nama dosen dan prodi
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    //dapatkan nama Periode
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_rapor', 'kode_periode');
    }

    public function getNilaiBkdAttribute()
    {

        // if ternari jika $this->bkd_pendidikan; jika bernilai M maka nilai 100, jika tidak ada maka 0
        // $pendidikan = $this->bkd_pendidikan == 'M' ? 100 : 0;
        // $penelitian = $this->bkd_penelitian == 'M' ? 100 : 0;
        // $ppm = $this->bkd_ppm == 'M' ? 100 : 0;
        // $penunjangan = $this->bkd_penunjangan == 'M' ? 100 : 0;
        // $kewajibankhusus = $this->bkd_kewajibankhusus == 'M' ? 100 : 0;

        // $total_bkd = ($pendidikan + $penelitian + $ppm + $penunjangan + $kewajibankhusus) / 5;
        $total_bkd = $this->bkd_total >= 12 ? 100 : ($this->bkd_total / 12) * 100;
        return $total_bkd * 0.5;
    }

    public function getNilaiEdomAttribute()
    {
        //jika edom_materipembelajaran bernilai lebih dari 3.00 maka nilai 100 jika tidak ada maka nilai yang bandingkan ke 3.00 mencapai berapa persen
        $materipembelajaran = $this->edom_materipembelajaran >= 3.00 ? 100 : ($this->edom_materipembelajaran / 3.00) * 100;
        $pengelolaankelas = $this->edom_pengelolaankelas >= 3.00 ? 100 : ($this->edom_pengelolaankelas / 3.00) * 100;
        $prosespengajaran = $this->edom_prosespengajaran >= 3.00 ? 100 : ($this->edom_prosespengajaran / 3.00) * 100;
        $penilaian = $this->edom_penilaian >= 3.00 ? 100 : ($this->edom_penilaian / 3.00) * 100;

        $total_edom = ($materipembelajaran + $pengelolaankelas + $prosespengajaran + $penilaian) / 4;

        return $total_edom * 0.25;
    }

    public function getNilaiEdasepAttribute()
    {
        $atasan = $this->edasep_atasan >= 90 ? 100 : ($this->edasep_atasan / 90) * 100;
        $sejawat = $this->edasep_sejawat >= 90 ? 100 : ($this->edasep_sejawat / 90) * 100;
        // $bawahan = $this->edasep_bawahan >= 90 ? 100 : ($this->edasep_bawahan / 90) * 100;

        // $total_edasep = ($atasan + $sejawat + $bawahan) / 3;
        $total_edasep = ($atasan + $sejawat) / 2;

        return $total_edasep * 0.25;
    }

    public function getNilaiTotalAttribute()
    {
        return $this->nilai_bkd + $this->nilai_edom + $this->nilai_edasep;
    }

    public function getGradeAttribute()
    {
        //Sangat Baik, Baik, Cukup, Kurang, Sangat Kurang
        if ($this->nilai_total >= 85) {
            return 'Sangat Baik';
        } elseif ($this->nilai_total >= 70) {
            return 'Baik';
        } elseif ($this->nilai_total >= 60) {
            return 'Cukup';
        } elseif ($this->nilai_total >= 50) {
            return 'Kurang';
        } else {
            return 'Sangat Kurang';
        }
    }
}
