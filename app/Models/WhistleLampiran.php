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
        'path_file',       // Kolom yang menyimpan path file yang diunggah
        'jenis_lampiran',  // Kolom baru: 'file' atau 'url'
        'url_eksternal',   // Kolom baru: untuk menyimpan URL Google Drive
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

    // Accessor untuk mendapatkan nama file
    public function getFileNameAttribute()
    {
        if ($this->jenis_lampiran === 'file' && !empty($this->path_file)) {
            return basename($this->path_file);
        } elseif ($this->jenis_lampiran === 'url' && !empty($this->url_eksternal)) {
            // Untuk URL, bisa mencoba mendapatkan nama dari path URL atau mengembalikan URL itu sendiri
            $path = parse_url($this->url_eksternal, PHP_URL_PATH);
            return $path ? basename($path) : $this->url_eksternal; // Mengembalikan URL jika tidak bisa mendapatkan nama
        }
        return null;
    }

    // Accessor untuk mendapatkan ukuran file (hanya berlaku untuk file fisik)
    public function getFileSizeAttribute()
    {
        if ($this->jenis_lampiran === 'file' && !empty($this->path_file)) {
            try {
                // Pastikan file path tidak null atau empty
                if (empty($this->path_file)) {
                    return 0;
                }

                // Coba beberapa kemungkinan path
                $possiblePaths = [
                    $this->path_file,                    // Path langsung
                    'uploads/' . $this->path_file,       // Jika file disimpan di folder uploads
                    'files/' . $this->path_file,         // Jika file disimpan di folder files
                    ltrim($this->path_file, '/'),        // Hilangkan leading slash jika ada
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
                    'file_path' => $this->path_file,
                    'model_id' => $this->id,
                    'checked_paths' => $possiblePaths
                ]);

                return 0;
            } catch (\Exception $e) {
                // Log error untuk debugging
                Log::error('Error getting file size', [
                    'file_path' => $this->path_file,
                    'model_id' => $this->id,
                    'error' => $e->getMessage()
                ]);
                
                return 0;
            }
        }
        return 0; // Return 0 for URL types
    }

    // Accessor untuk mendapatkan ekstensi file (hanya berlaku untuk file fisik)
    public function getFileExtensionAttribute()
    {
        if ($this->jenis_lampiran === 'file' && !empty($this->path_file)) {
            return pathinfo($this->path_file, PATHINFO_EXTENSION);
        }
        return null; // Return null for URL types
    }

    // Accessor untuk mendapatkan URL lampiran (file fisik atau URL eksternal)
    public function getFileUrlAttribute()
    {
        if ($this->jenis_lampiran === 'url' && !empty($this->url_eksternal)) {
            return $this->url_eksternal;
        } elseif ($this->jenis_lampiran === 'file' && !empty($this->path_file)) {
            // Coba beberapa kemungkinan path untuk generate URL
            $possiblePaths = [
                $this->path_file,
                'uploads/' . $this->path_file,
                'files/' . $this->path_file,
                ltrim($this->path_file, '/'),
            ];

            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    return asset('storage/' . $path);
                }
            }
        }
        return null;
    }

    // Accessor untuk memeriksa keberadaan file (hanya berlaku untuk file fisik)
    public function getFileExistsAttribute()
    {
        if ($this->jenis_lampiran === 'file' && !empty($this->path_file)) {
            $possiblePaths = [
                $this->path_file,
                'uploads/' . $this->path_file,
                'files/' . $this->path_file,
                ltrim($this->path_file, '/'),
            ];

            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path) || Storage::disk('local')->exists($path)) {
                    return true;
                }
            }
        }
        return false;
    }

    // Accessor untuk mendapatkan ukuran file yang diformat
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size; // Menggunakan accessor getFileSizeAttribute()
        
        if ($bytes == 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        
        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}