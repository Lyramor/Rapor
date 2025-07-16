<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use Illuminate\Console\Command;
use App\Models\MasterPerwalian;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ambilDataPerwalian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:syn-perwalian';

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
        $this->info('Mulai mengambil data perwalian...');

        // ambil data mahasiswa terlebih dahulu where periode masuk 20191, 20201, 20211, 20221, 20231, dan program studi Teknik Industri, Teknologi Pangan, Teknik Mesin, Teknik Informatika, Teknik Lingkungan, Perencanaan Wilayah dan Kota
        $mahasiswa = Mahasiswa::whereIn('periodemasuk', [
                '20191'
                // '20201',
                // '20211',
                // '20221',
                // '20231'
                // 20181
            ])
            ->whereIn('programstudi', [
                // 'Teknik Industri',
                'Teknologi Pangan',
                'Teknik Mesin',
                'Teknik Informatika',
                'Teknik Lingkungan',
                'Perencanaan Wilayah dan Kota'
            ])
            ->where('statusmahasiswa', 'Aktif')
            ->orderBy('nim', 'asc')
            ->get();

        $this->info('Jumlah mahasiswa yang ditemukan: ' . $mahasiswa->count());

        foreach ($mahasiswa as $mhs) {
            // ambil data nim dari mhs
            $nim = $mhs->nim;

            sleep(2); // delay 1 detik untuk menghindari rate limit

            $url = "https://api.sevimaplatform.com/siakadcloud/v1/mahasiswa/{$nim}/perwalian";

            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'X-App-Key'     => env('SEVIMA_APP_KEY'),
                'X-Secret-Key'  => env('SEVIMA_SECRET_KEY'),
            ])
            ->timeout(3600)
            ->retry(3, 2000, function ($exception, $request) {
                if ($exception->getCode() === 429) {
                    logger()->warning('⚠️ Rate limit 429 terjadi, retrying...');
                    return true;
                }
                return $exception instanceof \Illuminate\Http\Client\RequestException;
            })
            ->get($url);
            
            if (!$response->successful()) {
                $this->error("Gagal akses perwalian untuk NIM $nim. Status: " . $response->status());
                continue;
            }

            foreach ($response['data'] as $item) {
                $attr = $item['attributes'];

                MasterPerwalian::updateOrCreate(
                [
                    'id_periode' => $attr['id_periode'],
                    'nim' => $attr['nim'],
                ],
                [
                    'id' => Str::uuid(),
                    'id_periode' => $attr['id_periode'],
                    'nim' => $attr['nim'],
                    'id_status_mahasiswa' => $attr['id_status_mahasiswa'] ?? null,
                    'status_mahasiswa' => $attr['status_mahasiswa'] ?? null,
                    'nip_dosen_pembimbing' => $attr['nip_dosen_pembimbing'] ?? null,
                    'semester_mahasiswa' => $attr['semester_mahasiswa'] ?? null,
                    'ips' => $attr['ips'] ?? null,
                    'ipk' => $attr['ipk'] ?? null,
                    'ipk_lulus' => $attr['ipk_lulus'] ?? null,
                    'sks_semester' => $attr['sks_semester'] ?? 0,
                    'sks_total' => $attr['sks_total'] ?? 0,
                    'sks_lulus' => $attr['sks_lulus'] ?? 0,
                    'tanggal_validasi_krs' => $attr['tanggal_validasi_krs'] !== '' ? $attr['tanggal_validasi_krs'] : null,
                    'tanggal_sk' => $attr['tanggal_sk'] !== '' ? $attr['tanggal_sk'] : null,
                    'nomor_sk' => $attr['nomor_sk'] ?? null,
                    'alasan_cuti' => $attr['alasan_cuti'] ?? null,
                ]);
            }
            $this->info("✓ Perwalian NIM {$nim} disimpan.");
        }
        $this->info("✅ Sinkronisasi selesai.");
    }
}