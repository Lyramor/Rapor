<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\WhistleRiwayat;

class WhistlePengaduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'whistle_pengaduan';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'judul_pengaduan',
        'uraian_pengaduan',
        'anonymous',
        'kode_pengaduan',
        'status_pengaduan',
        'kategori_pengaduan_id',
        'tanggal_pengaduan',
        'pelapor_id'
    ];

    protected $casts = [
        'anonymous' => 'boolean',
        'tanggal_pengaduan' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            
            if (empty($model->kode_pengaduan)) {
                $model->kode_pengaduan = 'WB' . date('Ymd') . rand(1000, 9999);
            }
        });
    }

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(RefKategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function lampiran()
    {
        return $this->hasMany(WhistleLampiran::class, 'pengaduan_id');
    }

    public function pihakTerlibat()
    {
        return $this->hasMany(WhistlePihakTerlibat::class, 'pengaduan_id');
    }

    public function riwayat()
    {
        return $this->hasMany(WhistleRiwayat::class, 'pengaduan_id');
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('pelapor_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pengaduan', $status);
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_pengaduan_id', $kategoriId);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'proses' => 'badge-info',
            'selesai' => 'badge-success'
        ];

        return $badges[$this->status_pengaduan] ?? 'badge-secondary';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu',
            'proses' => 'Dalam Proses',
            'selesai' => 'Selesai'
        ];

        return $statuses[$this->status_pengaduan] ?? 'Unknown';
    }

    public function getIsPelaporAttribute()
    {
        return !$this->anonymous && $this->pelapor_id;
    }
}