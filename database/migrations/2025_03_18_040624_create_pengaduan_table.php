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
        Schema::create('whistle_pengaduan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul_pengaduan');
            $table->text('uraian_pengaduan');
            $table->boolean('anonymous')->default(false);
            $table->string('kode_pengaduan')->unique();
            $table->enum('status_pengaduan', ['pending', 'proses', 'selesai'])->default('pending');
            $table->uuid('kategori_pengaduan_id');
            $table->dateTime('tanggal_pengaduan')->default(now());
            $table->uuid('pelapor_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_pengaduan_id')->references('id')->on('ref_kategori_pengaduan')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pelapor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whistle_pengaduan');
    }
};
