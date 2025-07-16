<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RemedialAjuan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_ajuan';

    protected $fillable = [
        'id',
        'remedial_periode_id',
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

    //remedial periode
    public function remedialperiode()
    {
        return $this->belongsTo(RemedialPeriode::class, 'remedial_periode_id', 'id');
    }

    //remedialajuandetail
    public function remedialajuandetail()
    {
        return $this->hasMany(RemedialAjuanDetail::class);
    }

    // user
    public function userverifikasi()
    {
        return $this->belongsTo(User::class, 'verified_by', 'username');
    }
}
