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
        Schema::create('btq_penilaian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('no_urut');
            $table->string('jenis_penilaian');
            $table->text('text_penilaian');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btq_penilaian');
    }
};
