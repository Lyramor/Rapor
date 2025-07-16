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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('responden_id');
            $table->uuid('pertanyaan_id');
            $table->integer('jawaban_numerik')->nullable();
            $table->text('jawaban_essay')->nullable();
            $table->timestamps();

            $table->foreign('responden_id')->references('id')->on('responden_kuesionersdm')->onDelete('restrict');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
