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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('emailkampus')->nullable();
            $table->string('gelombang')->nullable();
            $table->string('jalurpendaftaran')->nullable();
            $table->string('jeniskelamin')->nullable();
            $table->string('kelasperkuliahan')->nullable();
            $table->string('konsentrasi')->nullable();
            $table->string('nama');
            $table->string('namaibu');
            $table->string('nik')->nullable();
            $table->string('nim')->unique();
            $table->string('nohp')->nullable();
            $table->string('periodemasuk')->nullable();
            $table->string('programstudi')->nullable();
            $table->string('sistemkuliah')->nullable();
            $table->string('statusmahasiswa')->nullable();
            $table->date('tanggallahir')->nullable();
            $table->string('tempatlahir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
