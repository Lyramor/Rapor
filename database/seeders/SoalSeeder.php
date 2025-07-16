<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use Illuminate\Support\Str;

class SoalSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi tabel kuesioner_soal.
     */
    public function run(): void
    {
        $soal_list = [
            // Soal untuk Bawahan
            'Kejujuran (Bawahan)',
            'Loyalitas pada Perusahaan (Bawahan)',
            'Kerjasama (Bawahan)',
            'Kehadiran Tepat Waktu (Bawahan)',
            'Kepemimpinan (Bawahan)',
            'Inisiatif/Prakarsa (Bawahan)',
            'Tanggungjawab (Bawahan)',
            'Ketaatan pada Organisasi (Bawahan)',
            'Nyunda dan Nyantri (Bawahan)',
            'Prestasi Kerja (Bawahan)',

            // Soal untuk Sejawat
            'Kejujuran (Sejawat)',
            'Loyalitas pada Perusahaan (Sejawat)',
            'Kerjasama (Sejawat)',
            'Kehadiran Tepat Waktu (Sejawat)',
            'Kepemimpinan (Sejawat)',
            'Inisiatif/Prakarsa (Sejawat)',
            'Tanggungjawab (Sejawat)',
            'Ketaatan pada Organisasi (Sejawat)',
            'Nyunda dan Nyantri (Sejawat)',
            'Prestasi Kerja (Sejawat)',
        ];

        foreach ($soal_list as $nama_soal) {
            Soal::create([
                'id' => Str::uuid(),
                'nama_soal' => $nama_soal,
                'keterangan' => "Penilaian terhadap $nama_soal",
                'soal_acak' => false,
                'publik' => true,
            ]);
        }
    }
}
