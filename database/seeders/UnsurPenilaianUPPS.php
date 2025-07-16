<?php

namespace Database\Seeders;

use App\Models\UnsurPenilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UnsurPenilaianUPPS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unsur_penilaian = [
            [
                // id uuid
                'id' => Str::uuid(),
                'nama' => 'Lingkungan Kerja dan Komunikasi',
                'nilai_capai' => 70,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Informasi dan Kebijakan Fakultas',
                'nilai_capai' => 70,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Fasilitas dan Sarana Pendukung',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Penugasan dan Kejelasan Tugas',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kesejahteraan dan Pendapatan',
                'nilai_capai' => 80,
            ],
            

        ];

        foreach ($unsur_penilaian as $unsur) {
            UnsurPenilaian::create($unsur);
        }
    }
}
