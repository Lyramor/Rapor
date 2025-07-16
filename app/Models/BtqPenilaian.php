<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BtqPenilaian extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'btq_penilaian';

    protected $fillable = [
        'no_urut',
        'jenis_penilaian',
        'text_penilaian',
        'text_penilaian_self',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
