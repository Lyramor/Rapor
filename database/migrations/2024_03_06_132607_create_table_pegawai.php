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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('jabatan_fungsional')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->string('agama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->uuid('unit_kerja_id');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
