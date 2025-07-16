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
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->integer('scale_range_min')->nullable()->default(0);
            $table->integer('scale_range_max')->nullable()->default(0);
            $table->string('scale_text_min')->nullable();
            $table->string('scale_text_max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropColumn('scale_range_min');
            $table->dropColumn('scale_range_max');
            $table->dropColumn('scale_text_min');
            $table->dropColumn('scale_text_max');
        });
    }
};
