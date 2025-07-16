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
        Schema::create('soal_kuesionerSDM', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kuesioner_sdm_id');
            $table->foreign('kuesioner_sdm_id')->references('id')->on('kuesioner_sdm')->onDelete('restrict');
            $table->uuid('soal_id');
            $table->foreign('soal_id')->references('id')->on('soal')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuesionerSDM');
    }
};
