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
        Schema::create('sisipan_ajuan_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sisipan_ajuan_id');
            // foreign key
            $table->foreign('sisipan_ajuan_id')->references('id')->on('sisipan_ajuan')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('krs_id');
            $table->foreign('krs_id')->references('id')->on('krs')->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode_periode');
            $table->string('idmk');
            $table->string('namakelas');
            $table->string('nip');
            $table->decimal('harga_sisipan', 10, 2)->default(0);
            $table->string('status_ajuan')->default('Konfirmasi Pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_ajuan_detail');
    }
};
