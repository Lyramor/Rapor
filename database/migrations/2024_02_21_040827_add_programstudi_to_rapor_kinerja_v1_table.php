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
        Schema::table('rapor_kinerja_v1', function (Blueprint $table) {
            $table->string('programstudi')->after('dosen_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapor_kinerja_v1', function (Blueprint $table) {
            $table->dropColumn('programstudi');
        });
    }
};
