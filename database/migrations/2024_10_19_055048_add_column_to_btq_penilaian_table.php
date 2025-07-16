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
        Schema::table('btq_penilaian', function (Blueprint $table) {
            $table->string('text_penilaian_self')->after('text_penilaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btq_penilaian', function (Blueprint $table) {
            $table->dropColumn('text_penilaian_self');
        });
    }
};
