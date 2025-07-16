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
        Schema::create('whistle_riwayat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengaduan_id');
            $table->enum('status_riwayat', ['pending', 'proses', 'selesai']);
            $table->timestamp('timestamp')->useCurrent();
            $table->uuid('updated_by');
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('whistle_pengaduan')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whistle_riwayat');
    }
};
