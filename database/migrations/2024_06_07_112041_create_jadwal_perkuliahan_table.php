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
        Schema::create('jadwal_perkuliahan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('programstudi')->nullable();
            $table->string('kodemk')->nullable();
            $table->string('matakuliah')->nullable();
            $table->string('kurikulum')->nullable();
            $table->string('periode')->nullable();
            $table->string('kelas')->nullable();
            $table->integer('sks')->nullable();
            $table->string('sistemkuliah')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->integer('jumlahpesertakelas')->nullable();
            $table->integer('pertemuan')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('hari')->nullable();
            $table->time('waktumulai')->nullable();
            $table->time('waktuselesai')->nullable();
            $table->string('ruang')->nullable();
            $table->string('metodepembelajaran')->nullable();
            $table->string('jenispertemuan')->nullable();
            $table->string('nidn')->nullable();
            $table->string('nip')->nullable();
            $table->string('dosenpengajar')->nullable();
            $table->string('statuspengajaran')->nullable();
            $table->text('realisasimateri')->nullable();
            $table->text('rencanamateri')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('kelasid')->nullable();
            $table->timestamp('lastupdate')->nullable();
            $table->string('jadwalid')->nullable();
            $table->timestamp('lastinsert')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_perkuliahan');
    }
};
