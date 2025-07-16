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
        Schema::table('soal_kuesionerSDM', function (Blueprint $table) {
            $table->uuid('unsur_penilaian_id');
            $table->foreign('unsur_penilaian_id')
                ->references('id')
                ->on('unsur_penilaian')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_kuesionerSDM', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['unsur_penilaian_id']);

            // Drop kolom
            $table->dropColumn('unsur_penilaian_id');
        });
    }
};
