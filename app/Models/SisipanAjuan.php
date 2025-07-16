<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisipanAjuan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sisipan_ajuan';

    protected $fillable = [
        'id',
        'sisipan_periode_id',
        'nim',
        'programstudi',
        'va',
        'total_bayar', //total yang harus dibayarkan
        'jumlah_bayar', // jumlah yang telah dibayarkan
        'status_pembayaran', //status pembayaran 'Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Lunas' , 'Ditolak'
        'bukti_pembayaran',
        'tgl_pembayaran',
        'tgl_pengajuan',
        'is_lunas',
        'verified_by',
    ];

    //mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    //sisipan periode
    public function sisipanperiode()
    {
        return $this->belongsTo(SisipanPeriode::class, 'sisipan_periode_id', 'id');
    }

    //sisipanajuandetail
    public function sisipanajuandetail()
    {
        return $this->hasMany(SisipanAjuanDetail::class);
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'programstudi', 'nama_unit');
    }

    // user
    public function userverifikasi()
    {
        return $this->belongsTo(User::class, 'verified_by', 'username');
    }
}
