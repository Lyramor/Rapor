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
        Schema::table('pegawai', function (Blueprint $table) {
            $table->renameColumn('pangkat', 'golpangkat');
            $table->renameColumn('jabatan_fungsional', 'jabatanfungsional');
            $table->renameColumn('jenis_pegawai', 'jenispegawai');
            // change jk from enum tu string and rename to jeniskelamin
            $table->dropColumn('jk');
            $table->string('jeniskelamin')->nullable();
            $table->renameColumn('tempat_lahir', 'tempatlahir');
            $table->renameColumn('tanggal_lahir', 'tanggallahir');
            $table->renameColumn('no_hp', 'nohp');
            $table->string('alamat')->nullable();
            $table->string('jabatanstruktural')->nullable();
            $table->string('pendidikanterakhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->renameColumn('golpangkat', 'pangkat');
            $table->renameColumn('jabatanfungsional', 'jabatan_fungsional');
            $table->renameColumn('jenispegawai', 'jenis_pegawai');
            // change jeniskelamin from string to enum and rename to jk
            $table->dropColumn('jeniskelamin');
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->renameColumn('tempatlahir', 'tempat_lahir');
            $table->renameColumn('tanggallahir', 'tanggal_lahir');
            $table->renameColumn('nohp', 'no_hp');
            $table->dropColumn('alamat');
            $table->dropColumn('jabatanstruktural');
            $table->dropColumn('pendidikanterakhir');
        });
    }
};
