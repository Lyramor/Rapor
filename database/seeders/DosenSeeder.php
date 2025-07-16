<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Exception;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat instance dari Guzzle Client
        $client = new Client();

        // URL target untuk mendapatkan access token
        $tokenUrl = 'https://unpas.siakadcloud.com/live/token';
        try {
            // Lakukan permintaan POST untuk mendapatkan access token
            $response = $client->request('POST', $tokenUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'unpas',
                    'client_secret' => 'gM5S5N%4'
                ]
            ]);

            // Dapatkan body respons dalam bentuk string
            $body = $response->getBody();

            // Ubah body respons dari JSON menjadi array asosiatif
            $data = json_decode($body, true);

            // Ambil access token dari data respons
            $accessToken = $data['access_token'];

            // Simpan access token dalam sesi atau penyimpanan sementara lainnya
            $_SESSION['access_token'] = $accessToken;

            // Tampilkan access token
            echo 'Access Token: ' . $accessToken;

            // Menggunakan access token untuk request berikutnya
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dosen', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_SESSION['access_token'] // Gunakan access token dari sesi
                ]
            ]);

            // Dapatkan body respons dalam bentuk string
            $body = $response->getBody();

            // Tampilkan data yang diperoleh dari request berikutnya
            echo $body;
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            echo 'Error: ' . $e->getMessage();
        }
    }
}
