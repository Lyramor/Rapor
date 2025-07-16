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
        Schema::table('role_user', function (Blueprint $table) {
            $table->uuid('unit_kerja_id')->nullable()->after('role_id');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['unit_kerja_id']);
            $table->dropColumn('unit_kerja_id');
            //
        });
    }
};
