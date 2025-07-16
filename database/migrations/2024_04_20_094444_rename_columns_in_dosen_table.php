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
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('email');
            $table->dropColumn('nohp');
            $table->dropColumn('tanggallahir');
            $table->dropColumn('tempatlahir');
            $table->dropColumn('agama');
            $table->dropColumn('alamat');
            $table->dropColumn('golpangkat');
            $table->dropColumn('jabatanfungsional');
            $table->dropColumn('jabatanstruktural');
            $table->dropColumn('jeniskelamin');
            $table->dropColumn('jenispegawai');
            $table->dropColumn('pendidikanterakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->string('nama');
            $table->string('email');
            $table->string('nohp');
            $table->date('tanggallahir');
            $table->string('tempatlahir');
            $table->string('agama');
            $table->string('alamat');
            $table->string('golpangkat');
            $table->string('jabatanfungsional');
            $table->string('jabatanstruktural');
            $table->string('jeniskelamin');
            $table->string('jenispegawai');
            $table->string('pendidikanterakhir');
        });
    }
};
