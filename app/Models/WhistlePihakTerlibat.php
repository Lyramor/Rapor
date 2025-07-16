<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WhistlePihakTerlibat extends Model
{
    use HasFactory;

    protected $table = 'whistle_pihak_terlibat';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pengaduan_id',
        'nama_lengkap',
        'jabatan'
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
}