<?php

namespace Database\Seeders;

use App\Models\UnsurPenilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UnsurPenilaianSeeder extends Seeder
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
                'nama' => 'Nyunda dan Nyantri',
                'nilai_capai' => 70,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kejujuran',
                'nilai_capai' => 70,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Prestasi Kerja',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Loyalitas',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Tanggung Jawab',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Ketaatan',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Prakarsa/Inisiatif',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kepemimpinan',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kerjasama',
                'nilai_capai' => 80,
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kehadiran Tepat Waktu',
                'nilai_capai' => 80,
            ],

        ];

        foreach ($unsur_penilaian as $unsur) {
            UnsurPenilaian::create($unsur);
        }
    }
}
