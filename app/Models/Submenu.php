<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Submenu extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'submenus';

    protected $fillable = [
        'id', 'nama_submenu', 'tautan_submenu', 'urutan_submenu', 'menu_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function subsubmenus()
    {
        return $this->hasMany(Subsubmenu::class);
    }
}
