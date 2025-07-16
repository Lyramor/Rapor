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
        Schema::table('btq_jadwal_mahasiswa', function (Blueprint $table) {
            $table->integer('nilai_bacaan')->default(0)->after('mahasiswa_id');
            $table->integer('nilai_tulisan')->default(0)->after('nilai_bacaan');
            $table->integer('nilai_hafalan')->default(0)->after('nilai_tulisan');
            $table->string('lampiran')->nullable()->after('nilai_hafalan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btq_jadwal_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('nilai_bacaan');
            $table->dropColumn('nilai_tulisan');
            $table->dropColumn('nilai_hafalan');
            $table->dropColumn('lampiran');
        });
    }
};
