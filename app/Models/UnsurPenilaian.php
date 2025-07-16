<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UnsurPenilaian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kuesioner_unsur_penilaian';

    protected $fillable = [
        'id',
        'nama',
        'nilai_capai',
    ];
}
