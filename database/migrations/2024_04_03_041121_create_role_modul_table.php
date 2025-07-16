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
        Schema::create('role_modul', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('role_id');
            $table->uuid('modul_id');
            // Define foreign keys
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->foreign('modul_id')->references('id')->on('moduls')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_modul');
    }
};
