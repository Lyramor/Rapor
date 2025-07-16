<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use Illuminate\Console\Command;
use App\Models\Krs;

class HitungPresensiKRS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hitung-presensi';

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
        $periode = '20242';
        $prodi = 'Ilmu Hukum';

        // get data mahasiswa where program studi
        $mahasiswa = Mahasiswa::where('programstudi', $prodi)
        ->where('periodemasuk', '20241')    
        ->get();

        foreach ($mahasiswa as $mhs) {
            // get krs where idperiode and nim
            $listKRS = Krs::where('nim', $mhs->nim)
                ->where('idperiode', $periode)
                ->get();

            foreach ($listKRS as $item) {
                // hitung jumlah presensi
                $result = $item->hitungJumlahPresensi();

                // tampilkan hasil
                $this->info("NIM: {$mhs->nim}, KRS ID: {$item->id}, Total Pertemuan: {$result['total_pertemuan']}, Hadir/Sakit/Izin: {$result['hadir_sakit_izin']}, Persentase: {$result['persentase']}%");
            }
        }


    }
}
