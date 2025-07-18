<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('remedial_ajuan_detail', function (Blueprint $table) {
            $table->dropColumn('status_ajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remedial_ajuan_detail', function (Blueprint $table) {
            $table->enum('status_ajuan', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }
};
