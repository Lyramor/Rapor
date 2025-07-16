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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('no_pertanyaan');
            $table->enum('jenis_pertanyaan', ['essay', 'range_nilai']);
            $table->string("pertanyaan");
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
        Schema::dropIfExists('pertanyaan');
    }
};
