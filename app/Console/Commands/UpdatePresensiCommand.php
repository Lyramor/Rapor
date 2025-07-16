<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BtqJadwalMahasiswa;

class UpdatePresensiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-presensi';

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
        // Ambil semua data dari BtqJadwalMahasiswa
        $mahasiswaJadwal = BtqJadwalMahasiswa::where(function ($query) {
            // Saring yang memiliki nilai bacaan, tulisan, atau hafalan lebih besar dari 0
            $query->where('nilai_bacaan', '>', 0)
                ->orWhere('nilai_tulisan', '>', 0)
                ->orWhere('nilai_hafalan', '>', 0);
        })->get();

        // Hitung berapa mahasiswa yang terpengaruh
        $count = $mahasiswaJadwal->count();

        if ($count === 0) {
            $this->info('Tidak ada data yang perlu diupdate.');
            return;
        }

        // Update presensi untuk setiap mahasiswa yang ditemukan
        foreach ($mahasiswaJadwal as $jadwal) {
            $jadwal->presensi = 1; // Set presensi menjadi 1 (hadir)
            $jadwal->save(); // Simpan perubahan
        }

        $this->info("Berhasil mengupdate presensi untuk {$count} mahasiswa.");
    }
}
