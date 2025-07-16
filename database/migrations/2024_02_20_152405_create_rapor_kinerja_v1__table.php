<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rapor_kinerja_v1', function (Blueprint $table) {
            $table->uuid('id')->primary;
            $table->string('periode_rapor');
            $table->foreign('periode_rapor')->references('kode_periode')->on('periodes')->onDelete('restrict');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('nip')->on('dosens')->onDelete('restrict');
            $table->string('bkd_pendidikan')->nullable();
            $table->string('bkd_penelitian')->nullable();
            $table->string('bkd_ppm')->nullable();
            $table->string('bkd_penunjangan')->nullable();
            $table->string('bkd_kewajibankhusus')->nullable();
            $table->float('edom_materipembelajaran')->default(0);
            $table->float('edom_pengelolaankelas')->default(0);
            $table->float('edom_prosespengajaran')->default(0);
            $table->float('edom_penilaian')->default(0);
            $table->float('edasep_atasan')->default(0);
            $table->float('edasep_sejawat')->default(0);
            $table->float('edasep_bawahan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_kinerja_v1');
    }
};
