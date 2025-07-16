<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterInvoice;
use Illuminate\Support\Facades\Http;
use App\Models\Mahasiswa;

class TarikInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tarik-invoice';

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
        $this->info('Menarik data invoice...');

        // kita ambil data mahasiswa telebih dahulu, misal dari tabel mahasiswa
        $mahasiswa = Mahasiswa::whereIn('periodemasuk', [
                '20191'
                // '20201',
                // '20211',
                // '20221',
                // '20231'
                // 20181
            ])
            ->whereIn('programstudi', [
                'Teknik Industri',
                // 'Teknologi Pangan',
                // 'Teknik Mesin',
                // 'Teknik Informatika',
                // 'Teknik Lingkungan',
                // 'Perencanaan Wilayah dan Kota'
            ])
            ->where('statusmahasiswa', 'Aktif')
            ->orderBy('nim', 'asc')
            ->get();

        $this->info('Jumlah mahasiswa yang ditemukan: ' . $mahasiswa->count());

        foreach ($mahasiswa as $mhs) {
            // ambil data nim dari mhs
            $nim = $mhs->nim;

            sleep(2); // delay 1 detik untuk menghindari rate limit

            $url = "https://api.sevimaplatform.com/siakadcloud/v1/invoice?f-nim={$nim}";

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
                $this->error("Gagal akses invoice untuk NIM $nim. Status: " . $response->status());
                continue;
            }

            foreach ($response['data'] as $item) {
                $attr = $item['attributes'];

                MasterInvoice::updateOrCreate(
                [
                    'id' => $item['id'],
                ],
                [
                    'id_tagihan' => $attr['id_tagihan'] ?? null,
                    'id_transaksi' => $attr['id_transaksi'] ?? null,
                    'kode_transaksi' => $attr['kode_transaksi'] ?? null,
                    'id_periode' => $attr['id_periode'],
                    'uraian' => $attr['uraian'],
                    'tanggal_transaksi' => $attr['tanggal_transaksi'],
                    'tanggal_akhir' => $attr['tanggal_akhir'],
                    'nim' => $attr['nim'],
                    'nama_mahasiswa' => $attr['nama_mahasiswa'],
                    'id_pendaftar' => $attr['id_pendaftar'] ?? null,
                    'nama_pendaftar' => $attr['nama_pendaftar'] ?? null,
                    'id_periode_daftar' => $attr['id_periode_daftar'] ?? null,
                    'id_jenis_akun' => $attr['id_jenis_akun'],
                    'jenis_akun' => $attr['jenis_akun'],
                    'id_mata_uang' => $attr['id_mata_uang'],
                    'nominal_tagihan' => $attr['nominal_tagihan'] ?? 0,
                    'nominal_denda' => $attr['nominal_denda'] ?? 0,
                    'nominal_potongan' => $attr['nominal_potongan'] ?? 0,
                    'total_potongan' => $attr['total_potongan'] ?? 0,
                    'nominal_terbayar' => $attr['nominal_terbayar'] ?? 0,
                    'nominal_sisa_tagihan' => $attr['nominal_sisa_tagihan'] ?? 0,
                    'is_lunas' => $attr['is_lunas'] ?? false,
                    'is_batal' => $attr['is_batal'] ?? false,
                    'is_rekon' => $attr['is_rekon'] ?? false,
                    'waktu_rekon' => $attr['waktu_rekon'] ?: null,
                    'tanggal_suspend' => $attr['tanggal_suspend'] ?: null,
                    'is_transfer_nanti' => $attr['is_transfer_nanti'] ?? false,
                    'tanggal_transfer' => $attr['tanggal_transfer'] ?: null,
                    'is_deleted' => $attr['is_deleted'] ?? false,
                ]);
            }
            $this->info("✓ Invoice NIM {$nim} disimpan.");
        }
        $this->info("✅ Sinkronisasi selesai.");
    }
}
