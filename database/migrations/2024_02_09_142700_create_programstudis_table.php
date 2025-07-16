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
        Schema::create('programstudis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedBigInteger('jenjang_id');
            $table->uuid('fakultas_id');
            $table->timestamps();

            $table->foreign('jenjang_id')->references('id')->on('jenjangs')->onDelete('restrict');
            $table->foreign('fakultas_id')->references('id')->on('fakultass')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programstudis', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['jenjang_id']);
        });
        Schema::dropIfExists('programstudis');
    }
};
