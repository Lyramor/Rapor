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
        Schema::table('responden_kuesionersdm', function (Blueprint $table) {
            $table->boolean('status_selesai')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responden_kuesionersdm', function (Blueprint $table) {
            $table->dropColumn('status_selesai');
        });
    }
};
