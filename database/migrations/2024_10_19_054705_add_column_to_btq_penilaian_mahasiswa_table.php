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
            $table->integer('nilai_self')->after('nilai')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btq_penilaian_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('nilai_self');
        });
    }
};
