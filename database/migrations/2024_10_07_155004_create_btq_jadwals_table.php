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
        Schema::create('btq_jadwal', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('kode_periode');
            $table->string('penguji_id');
            $table->foreign('penguji_id')
                ->references('username')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
            $table->integer('kuota');
            $table->string('hari');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruang');
            $table->text('deskripsi')->nullable();
            $table->enum('peserta', ['L', 'P']);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btq_jadwal');
    }
};
