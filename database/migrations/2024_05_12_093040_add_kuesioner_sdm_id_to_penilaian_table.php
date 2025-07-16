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
        Schema::table('penilaian', function (Blueprint $table) {
            $table->uuid('kuesioner_sdm_id')->after('jawaban_essay');
            $table->uuid('unsur_penilaian_id')->after('kuesioner_sdm_id');

            $table->foreign('kuesioner_sdm_id')->references('id')->on('kuesioner_sdm')->onDelete('restrict');
            $table->foreign('unsur_penilaian_id')->references('id')->on('unsur_penilaian')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropForeign(['kuesioner_sdm_id']);
            $table->dropForeign(['unsur_penilaian_id']);
            $table->dropColumn('kuesioner_sdm_id');
            $table->dropColumn('unsur_penilaian_id');
        });
    }
};
