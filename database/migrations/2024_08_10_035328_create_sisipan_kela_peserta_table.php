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
        Schema::create('sisipan_kelas_peserta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sisipan_kelas_id');
            $table->string('nim');
            $table->decimal('nnumerik', 5, 2)->nullable();
            $table->string('nhuruf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_kelas_peserta');
    }
};
