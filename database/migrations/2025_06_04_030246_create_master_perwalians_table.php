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
        Schema::create('master_perwalian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_periode');
            $table->string('nim');
            $table->string('id_status_mahasiswa');
            $table->string('status_mahasiswa');
            $table->string('nip_dosen_pembimbing');
            $table->integer('semester_mahasiswa');
            $table->decimal('ips', 3, 2)->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->decimal('ipk_lulus', 3, 2)->nullable();
            $table->integer('sks_semester');
            $table->integer('sks_total');
            $table->integer('sks_lulus');
            $table->date('tanggal_validasi_krs')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->text('alasan_cuti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_perwalian');
    }
};
