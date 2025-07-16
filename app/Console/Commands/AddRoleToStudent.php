<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use App\Models\RoleUser;
use App\Models\UnitKerja;

class AddRoleToStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-rolemhs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start');
        $listMahasiswa = Mahasiswa::whereHas('user')
            // ->where('programstudi', 'Ilmu Hukum')
            ->where('periodemasuk', '20241')
            ->where('statusmahasiswa', 'Aktif')
            ->get();

        $total_data = 0;

        foreach ($listMahasiswa as $mahasiswa) {
            $unitKerja = UnitKerja::where('nama_unit', $mahasiswa->programstudi)->first();

            // Check if UnitKerja exists
            if ($unitKerja) {
                $unitKerjaId = $unitKerja->id;

                // Update unit_kerja_id pada roleuser
                $roleUser = RoleUser::where('user_id', $mahasiswa->user->id)->first();

                // Check if RoleUser exists
                if ($roleUser) {
                    $roleUser->unit_kerja_id = $unitKerjaId;
                    $roleUser->save();
                    $total_data++;
                    $this->info($mahasiswa->nim . '-' . $mahasiswa->nama . ' - ' . $unitKerjaId . '-' . $mahasiswa->programstudi);
                } else {
                    // Handle case where RoleUser is null create role
                    RoleUser::create([
                        'user_id' => $mahasiswa->user->id,
                        'role_id' => '9c47fb98-6ff2-4da3-bb37-62042479d815',
                        'unit_kerja_id' => $unitKerjaId,
                    ]);
                }
            } else {
                // Handle case where UnitKerja is null
                $this->error("UnitKerja with nama_unit {$mahasiswa->programstudi} not found.");
                // Optionally, create a new UnitKerja or take other actions
            }
        }

        $this->info('Success' . $total_data . ' data updated');
    }
}
