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
        Schema::create('kuesioner_sdm', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_periode');
            $table->string('nama_kuesioner');
            $table->string('subjek_penilaian')->nullable();
            $table->enum('jenis_kuesioner', ['Atasan', 'Sejawat', 'Bawahan']);
            $table->dateTime('jadwal_kegiatan');
            $table->integer('nilai_akhir')->nullable();
            $table->timestamps();
            $table->foreign('subjek_penilaian')->references('nip')->on('pegawai')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_sdm');
    }
};
