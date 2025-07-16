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
        Schema::create('remedial_periode_tarif', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('remedial_periode_id');
            // foreign key update cascade, on delete restrict
            $table->foreign('remedial_periode_id')->references('id')->on('remedial_periode')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('remedial_periode_tarif');
    }
};
