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
        Schema::create('krs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('idperiode');
            $table->string('namakelas');
            $table->string('nim');
            $table->string('idmk');
            $table->string('namamk');
            $table->string('jenismatakuliah');
            $table->integer('sksmk');
            $table->integer('skspraktikum')->default(0);
            $table->integer('skstatapmuka')->default(0);
            $table->integer('skssimulasi')->default(0);
            $table->integer('skspraktlap')->default(0);
            $table->decimal('nnumerik', 5, 2)->nullable();
            $table->decimal('nangka', 3, 2)->nullable();
            $table->string('nhuruf')->nullable();
            $table->string('krsdiajukan');
            $table->string('krsdisetujui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
