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
        Schema::table('rapor_kinerja_v1', function (Blueprint $table) {
            $table->decimal('bkd_total', 10, 2)->default(0.00)->after('edasep_bawahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapor_kinerja_v1', function (Blueprint $table) {
            //drop coloumn bkd_total
            $table->dropColumn('bkd_total');
        });
    }
};
