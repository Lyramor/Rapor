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
        Schema::table('btq_penilaian_mahasiswa', function (Blueprint $table) {
            $table->string('penguji_id')->after('nilai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btq_penilaian_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('penguji_id');
        });
    }
};
