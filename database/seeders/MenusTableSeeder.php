<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Modul;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        $modul_id = Modul::where('nama_modul', 'Master Data')->value('id');
        // Generate sample menus
        DB::table('menus')->insert([
            [
                'id' => Str::uuid(),
                'nama_menu' => 'Menu 1',
                'tautan' => '/menu1',
                'urutan' => 1,
                'modul_id' => $modul_id,
            ],
            [
                'id' => Str::uuid(),
                'nama_menu' => 'Menu 2',
                'tautan' => '/menu2',
                'urutan' => 2,
                'modul_id' => $modul_id,
            ],
            // Tambahkan data menu lainnya sesuai kebutuhan
        ]);
    }
}
