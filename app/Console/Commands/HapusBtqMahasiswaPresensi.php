<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BtqJadwalMahasiswa;
use App\Models\BtqPenilaianMahasiswa;

class HapusBtqMahasiswaPresensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hapus-btq-mahasiswa-presensi';

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
        // Ambil semua jadwal mahasiswa yang presensinya = 2
        $jadwalMahasiswa = BtqJadwalMahasiswa::where('presensi', 2)->get();
        // jumlah data jadwal mahasiswa yang presensinya = 2
        $count = $jadwalMahasiswa->count();

        // info
        $this->info("Total data jadwal mahasiswa yang presensinya = 2: {$count}");

        foreach ($jadwalMahasiswa as $jadwal) {
            // Hapus semua penilaian terkait jadwal mahasiswa
            BtqPenilaianMahasiswa::where('btq_jadwal_mahasiswa_id', $jadwal->id)->delete();

            // Hapus data jadwal mahasiswa itu sendiri
            $jadwal->delete();

            $this->info("Data jadwal mahasiswa ID {$jadwal->mahasiswa_id} dan penilaiannya telah dihapus.");
        }

        $this->info('Proses penghapusan selesai.');
        return 0;
    }
}
