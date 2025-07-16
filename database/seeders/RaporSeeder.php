<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rapor;

class RaporSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan data contoh ke dalam tabel rapor
        Rapor::create([
            'periode_rapor' => '20231',
            'dosen_nip' => 'IF397',
            'bkd_pendidikan' => 'M',
            'bkd_penelitian' => 'M',
            'bkd_ppm' => 'M',
            'bkd_penunjangan' => 'M',
            'bkd_kewajibankhusus' => 'M',
            'edom_materipembelajaran' => 85.5,
            'edom_pengelolaankelas' => 90.0,
            'edom_prosespengajaran' => 88.0,
            'edom_penilaian' => 92.0,
            'edasep_atasan' => 80.0,
            'edasep_sejawat' => 85.0,
            'edasep_bawahan' => 90.0,
        ]);
    }
}
