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
        Schema::create('remedial_periode_prodi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('remedial_periode_id');
            $table->foreign('remedial_periode_id')->references('id')->on('remedial_periode')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('unit_kerja_id')->nullable();
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('nilai_batas')->nullable();
            $table->integer('presensi_batas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remedial_periode_prodi');
    }
};
