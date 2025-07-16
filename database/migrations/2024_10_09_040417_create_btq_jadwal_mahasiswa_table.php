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
        Schema::create('btq_jadwal_mahasiswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jadwal_id');
            $table->foreign('jadwal_id')
                ->references('id')
                ->on('btq_jadwal')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('mahasiswa_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btq_jadwal_mahasiswa');
    }
};
