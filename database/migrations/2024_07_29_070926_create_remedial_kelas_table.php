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
        Schema::create('remedial_kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('remedial_periode_id');
            $table->string('programstudi');
            $table->string('kodemk');
            $table->string('nip');
            $table->string('kode_edlink');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remedial_kelas');
    }
};
