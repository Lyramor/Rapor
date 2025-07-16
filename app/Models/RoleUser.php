<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RoleUser extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'role_user';

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
        'unit_kerja_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // unitkerja
    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }
}
