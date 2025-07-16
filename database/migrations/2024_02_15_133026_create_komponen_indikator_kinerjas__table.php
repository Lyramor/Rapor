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
        Schema::create('komponen_indikator_kinerjas', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('nama_indikator_kinerja')->nullable();
            $table->integer('bobot')->default(0);
            $table->integer('urutan')->default(0);
            $table->string('type_indikator')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_indikator_kinerjas');
    }
};
