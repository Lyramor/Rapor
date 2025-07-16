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
        Schema::table('kuesioner_sdm', function (Blueprint $table) {
            $table->dropColumn('jadwal_kegiatan');
            $table->date('jadwal_kegiatan_mulai')->nullable();
            $table->date('jadwal_kegiatan_selesai')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuesioner_sdm', function (Blueprint $table) {
            $table->dateTime('jadwal_kegiatan');
            $table->dropColumn('jadwal_kegiatan_mulai');
            $table->dropColumn('jadwal_kegiatan_selesai');
        });
    }
};
