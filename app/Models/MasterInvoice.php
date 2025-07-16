<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInvoice extends Model
{
    use HasFactory;

    protected $table = 'master_invoice';
    protected $primaryKey = 'id';

     protected $fillable = [
        'id',
        'id_tagihan',
        'id_transaksi',
        'kode_transaksi',
        'id_periode',
        'uraian',
        'tanggal_transaksi',
        'tanggal_akhir',
        'nim',
        'nama_mahasiswa',
        'id_pendaftar',
        'nama_pendaftar',
        'id_periode_daftar',
        'id_jenis_akun',
        'jenis_akun',
        'id_mata_uang',
        'nominal_tagihan',
        'nominal_denda',
        'nominal_potongan',
        'total_potongan',
        'nominal_terbayar',
        'nominal_sisa_tagihan',
        'is_lunas',
        'is_batal',
        'is_rekon',
        'waktu_rekon',
        'tanggal_suspend',
        'is_transfer_nanti',
        'tanggal_transfer',
        'is_deleted',
    ];
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
