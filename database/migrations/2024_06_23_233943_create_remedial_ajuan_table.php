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
        Schema::create('remedial_ajuan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('remedial_periode_id');
            // foreign key
            $table->foreign('remedial_periode_id')->references('id')->on('remedial_periode')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nim');
            $table->string('programstudi');
            $table->string('va');
            $table->decimal('total_bayar', 10, 2)->default(0);
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            $table->string('bukti_pembayaran')->nullable();
            $table->date('tgl_pengajuan');
            $table->string('status_pembayaran')->default('Menunggu Pembayaran');
            $table->boolean('is_lunas')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remedial_ajuan');
    }
};
