<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory, HasUuids;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fakultass';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'kode', 'nama'];

    /**
     * Get the program studis for the fakultas.
     */
    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
