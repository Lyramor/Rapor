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
        Schema::create('presensi_kuliah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('periodeakademik');
            $table->string('programstudi');
            $table->string('tahunkurikulum');
            $table->string('kodemk');
            $table->string('matakuliah');
            $table->string('kelas')->nullable();
            $table->string('sistemkuliah')->nullable();
            $table->string('kelasmahasiswa')->nullable();
            $table->integer('pertemuanke')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('hari')->nullable();
            $table->string('waktumengajar')->nullable();
            $table->string('jenisjadwal')->nullable();
            $table->string('statusperkuliahan')->nullable();
            $table->string('presensi')->nullable();
            $table->string('nama')->nullable();
            $table->string('nim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_kuliah');
    }
};
