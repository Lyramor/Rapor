<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WhistleRiwayat extends Model
{
    use HasFactory;

    protected $table = 'whistle_riwayat';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pengaduan_id',
        'status_riwayat',
        'timestamp',
        'updated_by',
        'catatan'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function pengaduan()
    {
        return $this->belongsTo(WhistlePengaduan::class, 'pengaduan_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu',
            'proses' => 'Dalam Proses',
            'selesai' => 'Selesai'
        ];

        return $statuses[$this->status_riwayat] ?? 'Unknown';
    }
}