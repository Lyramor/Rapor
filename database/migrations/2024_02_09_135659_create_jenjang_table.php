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
        Schema::create('jenjangs', function (Blueprint $table) {
            $table->id();
            $table->string('singkatan');
            $table->string('nama');
            $table->timestamps();
        });

        // Insert some data into 'jenjang' table
        DB::table('jenjangs')->insert([
            ['singkatan' => 'S1', 'nama' => 'Strata 1'],
            ['singkatan' => 'S2', 'nama' => 'Strata 2'],
            ['singkatan' => 'S3', 'nama' => 'Strata 3'],
            ['singkatan' => 'Prof', 'nama' => 'Profesi'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenjangs');
    }
};
