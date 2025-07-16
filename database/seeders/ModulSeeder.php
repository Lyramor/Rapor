<?php

namespace Database\Seeders;

use App\Models\Modul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modul::create([
            'id' => Str::uuid(),
            'nama_modul' => 'Master Data',
            'tautan' => '#',
            'urutan' => 1
        ]);
    }
}
