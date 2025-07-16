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
        Schema::create('master_invoice', function (Blueprint $table) {
            $table->string('id')->primary(); // contoh: 476912-624023
            $table->string('id_tagihan')->nullable();
            $table->string('id_transaksi')->nullable();;
            $table->string('kode_transaksi')->nullable();;
            $table->string('id_periode')->nullable();;
            $table->string('uraian')->nullable();
            $table->string('tanggal_transaksi')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('nim')->nullable();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('id_pendaftar')->nullable();
            $table->string('nama_pendaftar')->nullable();
            $table->string('id_periode_daftar')->nullable();
            $table->string('id_jenis_akun')->nullable();
            $table->string('jenis_akun')->nullable();
            $table->string('id_mata_uang')->nullable();
            $table->decimal('nominal_tagihan', 15, 2)->default(0);
            $table->decimal('nominal_denda', 15, 2)->default(0);
            $table->decimal('nominal_potongan', 15, 2)->default(0);
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('nominal_terbayar', 15, 2)->default(0);
            $table->decimal('nominal_sisa_tagihan', 15, 2)->default(0);
            $table->boolean('is_lunas')->default(false);
            $table->boolean('is_batal')->default(false);
            $table->boolean('is_rekon')->default(false);
            $table->string('waktu_rekon')->nullable();
            $table->string('tanggal_suspend')->nullable();
            $table->boolean('is_transfer_nanti')->default(false);
            $table->string('tanggal_transfer')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_invoice');
    }
};
