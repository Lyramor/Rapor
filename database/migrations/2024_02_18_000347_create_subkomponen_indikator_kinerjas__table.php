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
        Schema::create('subkomponen_indikator_kinerjas', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('subindikator_kinerja')->nullable();
            $table->string('target');
            $table->integer('urutan')->default(0);
            $table->uuid('komponen_indikator_kinerja_id');
            $table->foreign('komponen_indikator_kinerja_id')->references('id')->on('komponen_indikator_kinerjas')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkomponen_indikator_kinerjas');
    }
};
