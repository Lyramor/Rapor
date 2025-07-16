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
        Schema::create('kelas_kuliah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('periodeakademik');
            $table->string('programstudi');
            $table->string('kurikulum');
            $table->string('kodemk');
            $table->string('namamk');
            $table->string('namakelas');
            $table->string('sistemkuliah');
            $table->string('namakelasmahasiswa')->nullable();
            $table->integer('kapasitas');
            $table->date('tanggalmulai')->nullable();
            $table->date('tanggalselesai')->nullable();
            $table->integer('jumlahpertemuan')->nullable();
            $table->string('mbkm')->nullable();
            $table->string('hari')->nullable();
            $table->string('jammulai')->nullable();
            $table->string('jamselesai')->nullable();
            $table->string('jenispertemuan')->nullable();
            $table->string('metodepembelajaran')->nullable();
            $table->string('namaruang')->nullable();
            $table->string('nip')->nullable();
            $table->string('namadosen')->nullable();
            $table->string('kelasid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_kuliah');
    }
};
