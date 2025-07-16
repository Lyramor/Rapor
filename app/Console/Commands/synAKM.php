<?php

namespace App\Console\Commands;

use App\Models\AKM;
use Illuminate\Console\Command;
use App\Models\KelasKuliah;
use GuzzleHttp\Client;
use App\Models\Krs;
use App\Models\Mahasiswa;


class synAKM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:syn-akm';

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
        $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjaWQiOiJ1bnBhcyIsImlhdCI6MTczOTQxMjI2MywiZXhwIjoxNzM5NDE1ODYzfQ.aEhNXms2QyogBOV7udG49fmsn3uOip4FrkEkOvFp1x4";
        $limit = 10000;

        $formData = [];
        $formData['limit'] = $limit;

        //IDperiodelist
        $periodelist = [
            '20241',
            // '20231',
            // '20221',
            // '20211',
            // '20201',
            // '20191',
            // '20181',
        ];

        // kelaskuliah where in idperiode
        $mahasiswa = Mahasiswa::whereIn('periodemasuk', $periodelist)
            ->get();

        // foreach ($mahasiswa as $mhs) {
        $formData['idperiode'] = '20241';
        // $formData['nim'] = $mhs->nim;
        $countinsert = 0;

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/akmmahasiswa', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if ($data != null) {
                // Menggunakan array asosiatif untuk mengelompokkan data dan menghapus duplikat
                $groupedData = [];

                foreach ($data as $item) {
                    $groupedData[$item['idperiode'] . $item['nim']] = $item;
                }

                // Mengubah kembali array asosiatif menjadi array numerik
                $uniqueData = array_values($groupedData);

                foreach ($uniqueData as $akmData) {

                    $akm = AKM::create($akmData);
                    $this->info($akm);
                }
            }
        } catch (\Throwable $th) {
            $this->error('Error: ' . $th->getMessage());
        }
        // }
    }
}
