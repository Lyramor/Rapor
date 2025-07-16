<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus CHECK constraint yang menempel pada kolom jenis_kuesioner
        DB::statement('ALTER TABLE kuesioner_sdm DROP CONSTRAINT IF EXISTS kuesioner_sdm_jenis_kuesioner_check');
    }

    public function down(): void
    {
        // Restore CHECK jika ingin rollback (opsional)
        DB::statement("ALTER TABLE kuesioner_sdm ADD CONSTRAINT kuesioner_sdm_jenis_kuesioner_check CHECK (jenis_kuesioner IN ('Atasan', 'Sejawat', 'Bawahan'))");
    }
};
