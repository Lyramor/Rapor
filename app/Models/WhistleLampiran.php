<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WhistleLampiran extends Model
{
    use HasFactory;

    protected $table = 'whistle_lampiran';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pengaduan_id',
        'file',
        'keterangan'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function pengaduan()
    {
        return $this->belongsTo(WhistlePengaduan::class, 'pengaduan_id');
    }

    public function getFileNameAttribute()
    {
        return basename($this->file);
    }

    public function getFileSizeAttribute()
    {
        try {
            // Pastikan file path tidak null atau empty
            if (empty($this->file)) {
                return 0;
            }

            // Coba beberapa kemungkinan path
            $possiblePaths = [
                $this->file,                    // Path langsung
                'uploads/' . $this->file,       // Jika file disimpan di folder uploads
                'files/' . $this->file,         // Jika file disimpan di folder files
                ltrim($this->file, '/'),        // Hilangkan leading slash jika ada
            ];

            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    return Storage::disk('public')->size($path);
                }
            }

            // Jika tidak ditemukan di disk public, coba di disk local
            foreach ($possiblePaths as $path) {
                if (Storage::disk('local')->exists($path)) {
                    return Storage::disk('local')->size($path);
                }
            }

            // Log untuk debugging
            Log::warning('File not found in storage', [
                'file_path' => $this->file,
                'model_id' => $this->id,
                'checked_paths' => $possiblePaths
            ]);

            return 0;
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error getting file size', [
                'file_path' => $this->file,
                'model_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            
            return 0;
        }
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    public function getFileUrlAttribute()
    {
        if (empty($this->file)) {
            return null;
        }

        // Coba beberapa kemungkinan path untuk generate URL
        $possiblePaths = [
            $this->file,
            'uploads/' . $this->file,
            'files/' . $this->file,
            ltrim($this->file, '/'),
        ];

        foreach ($possiblePaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }

        return null;
    }

    public function getFileExistsAttribute()
    {
        if (empty($this->file)) {
            return false;
        }

        $possiblePaths = [
            $this->file,
            'uploads/' . $this->file,
            'files/' . $this->file,
            ltrim($this->file, '/'),
        ];

        foreach ($possiblePaths as $path) {
            if (Storage::disk('public')->exists($path) || Storage::disk('local')->exists($path)) {
                return true;
            }
        }

        return false;
    }

    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes == 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        
        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}