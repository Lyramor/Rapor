<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\UnitKerjaSeeder;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\AssignOp\Mod;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // FakultasSeeder::class,
            // ProgramStudiSeeder::class,
            // UnitKerjaSeeder::class,
            // UsersTableSeeder::class,
            // ModulSeeder::class,
            // ModulsTableSeeder::class,
            // MenusTableSeeder::class,
            UnsurPenilaianSeeder::class,

        ]);
    }
}
