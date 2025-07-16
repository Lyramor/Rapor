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
        Schema::table('remedial_ajuan', function (Blueprint $table) {
            $table->date('tgl_pembayaran')->nullable();
            $table->string('verified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remedial_ajuan', function (Blueprint $table) {
            $table->dropColumn('tgl_pembayaran');
            $table->dropColumn('verified_by');
        });
    }
};
