<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModulsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate sample moduls
        DB::table('moduls')->insert([
            [
                'id' => Str::uuid(),
                'nama_modul' => 'Master Data',
                'tautan' => '/modul1',
                'icon' => 'rapor.png',
                'urutan' => 1,
            ],
            [
                'id' => Str::uuid(),
                'nama_modul' => 'Rapor',
                'tautan' => '/modul2',
                'icon' => 'rapor.svg',
                'urutan' => 2,
            ],
            [
                'id' => Str::uuid(),
                'nama_modul' => 'Vakasi',
                'tautan' => '/modul3',
                'icon' => 'vakasi.svg',
                'urutan' => 3,
            ],
            // Add other modul data as needed
        ]);
    }
}
