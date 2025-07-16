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
        Schema::table('btq_jadwal', function (Blueprint $table) {
            $table->string('is_active')->default('aktif')->change();
            // $table->enum('is_active', ['aktif', 'proses', 'selesai'])->default('aktif')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btq_jadwal', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->change();
            // $table->boolean('is_active')->default(false)->change();
        });
    }
};
