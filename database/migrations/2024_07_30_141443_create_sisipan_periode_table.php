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
        Schema::create('sisipan_periode', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('unit_kerja_id')->nullable();
            $table->string('kode_periode');
            $table->string('nama_periode');
            $table->string('format_va');
            $table->boolean('add_nrp')->default(false);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            // $table->integer('nilai_batas')->nullable();
            $table->boolean('is_aktif')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_periode');
    }
};
