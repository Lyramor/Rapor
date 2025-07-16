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
        Schema::create('sisipan_ajuan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sisipan_periode_id');
            // foreign key
            $table->foreign('sisipan_periode_id')->references('id')->on('sisipan_periode')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nim');
            $table->string('programstudi');
            $table->string('va');
            $table->decimal('total_bayar', 10, 2)->default(0);
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            $table->string('bukti_pembayaran')->nullable();
            $table->date('tgl_pengajuan');
            $table->string('status_pembayaran')->default('Menunggu Pembayaran');
            $table->boolean('is_lunas')->default(false);
            $table->date('tgl_pembayaran')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisipan_ajuan');
    }
};
