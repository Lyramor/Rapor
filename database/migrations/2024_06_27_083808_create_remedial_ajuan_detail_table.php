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
        Schema::create('remedial_ajuan_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('remedial_ajuan_id');
            // foreign key
            $table->foreign('remedial_ajuan_id')->references('id')->on('remedial_ajuan')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('krs_id');
            $table->foreign('krs_id')->references('id')->on('krs')->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode_periode');
            $table->string('idmk');
            $table->string('namakelas');
            $table->decimal('harga_remedial', 10, 2)->default(0);
            $table->enum('status_ajuan', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remedial_ajuan_detail');
    }
};
