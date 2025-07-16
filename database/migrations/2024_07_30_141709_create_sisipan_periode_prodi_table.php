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
        Schema::create('sisipan_periode_prodi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sisipan_periode_id');
            $table->foreign('sisipan_periode_id')->references('id')->on('sisipan_periode')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('unit_kerja_id')->nullable();
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('nilai_batas')->nullable();
            $table->integer('presensi_batas')->nullable();
            $table->integer('batas_sks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_periode_prodi');
    }
};
