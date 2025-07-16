<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ref_kategori_pengaduan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kategori')->unique();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('ref_kategori_pengaduan')->insert([
            ['id' => Str::uuid(), 'nama_kategori' => 'Pelanggaran di Lingkungan Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_kategori' => 'Pelanggaran di Lingkungan Pimpinan/Dosen/Karyawan di Tingkat Universitas, Fakultas, atau Program Studi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kategori_pengaduan');
    }
};
