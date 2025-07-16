<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RoleModul extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'role_modul'; // Nama tabel pivot

    protected $fillable = [
        'id', // id tidak perlu diisi karena sudah menggunakan UUID
        'role_id',
        'modul_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }
}
