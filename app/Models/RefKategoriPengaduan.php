<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefKategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'ref_kategori_pengaduan';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_kategori'
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
        return $this->hasMany(WhistlePengaduan::class, 'kategori_pengaduan_id');
    }
}