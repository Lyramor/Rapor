<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subsubmenu extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'subsubmenus';

    protected $fillable = [
        'id', 'nama_subsubmenu', 'tautan_subsubmenu', 'urutan_subsubmenu', 'submenu_id'
    ];

    public function submenus()
    {
        return $this->belongsTo(Submenu::class);
    }
}
