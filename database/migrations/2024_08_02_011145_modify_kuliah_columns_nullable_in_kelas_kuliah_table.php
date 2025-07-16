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
        Schema::table('kelas_kuliah', function (Blueprint $table) {
            $table->string('sistemkuliah')->nullable()->change();
            $table->integer('kapasitas')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_kuliah', function (Blueprint $table) {
            $table->string('sistemkuliah')->nullable(false)->change();
            $table->integer('kapasitas')->default(0)->change();
        });
    }
};
