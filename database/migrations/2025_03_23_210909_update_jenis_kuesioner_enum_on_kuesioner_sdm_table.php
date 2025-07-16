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
        //
        Schema::table('kuesioner_sdm', function (Blueprint $table) {
            // Ubah tipe enum menjadi string
            $table->string('jenis_kuesioner')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('kuesioner_sdm', function (Blueprint $table) {
            // Kembalikan ke enum jika ingin rollback
            $table->enum('jenis_kuesioner', ['Atasan', 'Sejawat', 'Bawahan'])->change();
        });
    }
};
