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
        Schema::create('sisipan_periode_tarif', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sisipan_periode_id');
            // foreign key update cascade, on delete restrict
            $table->foreign('sisipan_periode_id')->references('id')->on('sisipan_periode')->onUpdate('cascade')->onDelete('restrict');
            $table->string('periode_angkatan');
            $table->integer('tarif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_periode_tarif');
    }
};
