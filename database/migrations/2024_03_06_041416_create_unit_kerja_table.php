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
        Schema::create('unit_kerja', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_unit');
            $table->string('nama_unit');
            $table->string('nama_unit_en')->nullable();
            $table->string('nama_singkat')->nullable();
            $table->uuid('parent_unit')->nullable();
            $table->string('jenis_unit')->nullable();
            $table->string('tk_pendidikan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('website')->nullable();
            $table->string('alamat_email')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('no_sk_akreditasi')->nullable();
            $table->date('tanggal_akreditasi')->nullable();
            $table->string('no_sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('gedung')->nullable();
            $table->string('akademik')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();

            // Menambahkan unique constraint untuk kolom id
            $table->unique('id');

            // Menambahkan foreign key untuk parent_unit
            $table->foreign('parent_unit')
                ->references('id')
                ->on('unit_kerja')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kerja');
    }
};
