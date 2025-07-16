<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'periodes';

    protected $fillable = [
        'id',
        'kode_periode',
        'nama_periode',
    ];
}
