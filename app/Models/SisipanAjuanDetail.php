<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SisipanAjuanDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_ajuan_detail';

    protected $fillable = [
        'id',
        'sisipan_ajuan_id',
        'kode_periode',
        'krs_id',
        'idmk',
        'namakelas',
        'nip',
        'harga_sisipan',
        'status_ajuan' // Konfirmasi Pembayaran, Konfirmasi Kelas, Diterima, Dibatalkan
    ];

    //sisipanAjuan
    public function sisipanajuan()
    {
        return $this->belongsTo(SisipanAjuan::class, 'sisipan_ajuan_id', 'id');
    }

    // kelas kuliah
    public function kelasKuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk');
        // ->where('namakelas', $this->namakelas)
        // ->where('periodeakademik', $this->kode_periode);
        // ->withNamaKelas($this->namakelas)
        // ->withPeriodeAkademik($this->kode_periode);
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
}
