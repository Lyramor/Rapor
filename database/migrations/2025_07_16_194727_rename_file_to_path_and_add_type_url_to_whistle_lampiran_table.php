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
        Schema::table('whistle_lampiran', function (Blueprint $table) {
            // Rename 'file' column to 'path_file'
            $table->renameColumn('file', 'path_file');

            // Add new columns
            $table->string('jenis_lampiran')->default('file')->after('path_file'); // 'file' atau 'url'
            $table->string('url_eksternal')->nullable()->after('jenis_lampiran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whistle_lampiran', function (Blueprint $table) {
            // Revert column name back
            $table->renameColumn('path_file', 'file');

            // Drop the new columns
            $table->dropColumn('url_eksternal');
            $table->dropColumn('jenis_lampiran');
        });
    }
};