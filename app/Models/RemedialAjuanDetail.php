<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class RemedialAjuanDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_ajuan_detail';

    protected $fillable = [
        'id',
        'remedial_ajuan_id',
        'kode_periode',
        'krs_id',
        'idmk',
        'namakelas',
        'nip',
        'harga_remedial',
        'status_ajuan' // Konfirmasi Pembayaran, Konfirmasi Kelas, Diterima, Dibatalkan
    ];

    //remedialAjuan
    public function remedialajuan()
    {
        return $this->belongsTo(RemedialAjuan::class, 'remedial_ajuan_id', 'id');
    }

    // kelas kuliah
    public function kelasKuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk');
        // ->where('namakelas', $this->namakelas)
        // ->where('periodeakademik', $this->kode_periode);
        // return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk')
        //     ->where('namakelas', $this->namakelas)
        //     ->where('periodeakademik', $this->idperiode);
    }

    // krs
    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id', 'id');
    }

    // dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    // matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk');
    }

    // jumlahPengajar
}
