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
        Schema::create('btq_penilaian_mahasiswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('btq_penilaian_id');
            $table->foreign('btq_penilaian_id')
                ->references('id')
                ->on('btq_penilaian')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->uuid('btq_jadwal_mahasiswa_id');
            $table->foreign('btq_jadwal_mahasiswa_id')
                ->references('id')
                ->on('btq_jadwal_mahasiswa')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('jenis_penilaian');
            $table->integer('nilai')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btq_penilaian_mahasiswa');
    }
};
