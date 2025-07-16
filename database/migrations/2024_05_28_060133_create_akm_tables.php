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
        Schema::create('akm', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nim', 12)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('idperiode', 6)->nullable();
            $table->char('statusmhs', 1)->nullable();
            $table->string('nip', 20)->nullable();
            $table->string('dosenpa', 100)->nullable();
            $table->decimal('ips', 3, 2)->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->unsignedTinyInteger('skssemester')->nullable();
            $table->unsignedSmallInteger('skstotal')->nullable();
            $table->decimal('ipklulus', 3, 2)->nullable();
            $table->unsignedSmallInteger('skslulus')->nullable();
            $table->unsignedTinyInteger('batassks')->nullable();
            $table->unsignedSmallInteger('skstempuh')->nullable();
            $table->unsignedTinyInteger('semmhs')->nullable();
            $table->date('tglsk')->nullable();
            $table->string('nosk', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akm');
    }
};
