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
        Schema::create('whistle_lampiran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengaduan_id');
            $table->string('file'); // Path file yang diunggah
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('whistle_pengaduan')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whistle_lampiran');
    }
};
