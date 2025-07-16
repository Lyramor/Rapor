<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'deskripsi',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function moduls()
    {
        return $this->belongsToMany(Modul::class, 'role_modul', 'role_id', 'modul_id');
    }

}
