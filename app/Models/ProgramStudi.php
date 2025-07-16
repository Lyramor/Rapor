<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fakultas;
use App\Models\Jenjang;

class ProgramStudi extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programstudis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'kode', 'nama', 'jenjang_id', 'fakultas_id'];

    /**
     * Get the jenjang that owns the program studi.
     */
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    /**
     * Get the fakultas that owns the program studi.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}
