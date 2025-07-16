<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'menus';

    protected $fillable = [
        'id', 'nama_menu', 'tautan', 'urutan', 'modul_id'
    ];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }
}
