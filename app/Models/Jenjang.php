<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenjangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama', 'singkatan'];

    /**
     * Get the program studis for the jenjang.
     */
    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
