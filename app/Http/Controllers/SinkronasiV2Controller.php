<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Exception;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Periode;
use App\Models\KelasKuliah;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\Krs;
use GuzzleHttp\Exception\RequestException;
use App\Models\AKM;
use App\Models\JadwalPerkuliahan;
use App\Helpers\UnitKerjaHelper;
use App\Models\PresensiKuliah;
use Illuminate\Support\Facades\Validator;


class SinkronasiV2Controller extends Controller
{
    function index()
    {
        // return response()->json(['message' => 'Hello ini dari Sinkronasi Controller']);
        // $fakultas_id = Fakultas::with('programStudis')->get();

        // Mengembalikan respons dalam format JSON
        // return response()->json($fakultas_id);
        // echo $fakultas_id;
        // return view('master.sinkronasi.index');
        echo "Silahkan pilih menu sinkronasi yang tersedia di sebelah kiri";
    }

    // mahasiswa
    function mahasiswa()
    {
        $programstudi = ProgramStudi::all();
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $periode = Periode::orderBy('kode_periode', 'desc')->take(50)->get();
        return view(
            'master.sinkronasi.mahasiswa',
            [
                'programstudi' => $programstudi,
                'periode' => $periode,
                'unitkerja' => $unitKerja
            ]
        );
    }

    // getDataMahasiswa
    function getDataMahasiswa(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            $formData = [];

            if ($request->programstudi != null) {
                $formData['programstudi'] = $request->get('programstudi');
            }

            if ($request->periodemasuk != null) {
                $formData['periodemasuk'] = $request->get('periodemasuk');
            }

            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data mahasiswa
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/biodatamhs', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data mahasiswa ke dalam tabel Mahasiswa
            $count_update = 0;
            $count_insert = 0;
            foreach ($data as $mahasiswaData) {
                $mahasiswa = Mahasiswa::where('nim', $mahasiswaData['nim'])
                    ->where('programstudi', $mahasiswaData['programstudi'])
                    ->first();

                // Jika data mahasiswa sudah ada, perbarui
                if ($mahasiswa) {
                    $mahasiswa->update($mahasiswaData);
                    $count_update++;
                } else {
                    // Jika tidak, buat data mahasiswa baru
                    $mahasiswaData['id'] = Str::uuid();
                    Mahasiswa::create($mahasiswaData);
                    $count_insert++;
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data mahasiswa berhasil disinkronkan,' . $count_update . " data berhasil diperbarui dan " . $count_insert . " data baru", 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // jadwalPerkuliahan
    function kelasKuliah()
    {
        // $programstudi = ProgramStudi::all();
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(35)->get();
        return view(
            'master.sinkronasi.kelas-kuliah',
            [
                'unitkerja' => $unitKerja,
                'periode' => $periode
            ]
        );
    }

    // jadwalPerkuliahan
    function jadwalKuliah()
    {
        // $programstudi = ProgramStudi::all();
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(35)->get();
        return view(
            'master.sinkronasi.jadwal-kuliah',
            [
                'unitkerja' => $unitKerja,
                'periode' => $periode
            ]
        );
    }

    // jadwalPerkuliahan
    function presensiKuliah()
    {
        $unitKerja = UnitKerjaHelper::getUnitKerja();
        // return response()->json($unitKerja);
        $programstudi = ProgramStudi::all();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(35)->get();
        return view(
            'master.sinkronasi.presensi-kuliah',
            [
                'programstudi' => $programstudi,
                'periode' => $periode,
                'unitkerja' => $unitKerja
            ]
        );
    }

    function remedial()
    {
        $programstudi = ProgramStudi::all();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(35)->get();
        return view(
            'master.sinkronasi.remedial.index',
            [
                'programstudi' => $programstudi,
                'periode' => $periode
            ]
        );
    }

    function akm()
    {
        $programstudi = ProgramStudi::all();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(35)->get();
        return view(
            'master.sinkronasi.akm',
            [
                'programstudi' => $programstudi,
                'periode' => $periode
            ]
        );
    }

    function getToken()
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

            // Menyimpan access token dalam variabel global
            $GLOBALS['access_token'] = $accessToken;

            //buat session token_sevima 
            session(['token_sevima' => $accessToken]);

            // Tampilkan access token
            return response()->json(['access_token' => $accessToken]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getDataDosen(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");
            $homebase = $request->get("homebase");

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                // 'homebase' => 'Teknik Informatika',
                'homebase' => $homebase,
                'limit' => 10000,
            ];

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data dosen
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dosen', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data dosen ke dalam tabel Dosen
            foreach ($data as $dosenData) {

                $pegawai = Pegawai::where('nip', $dosenData['nip'])->first();

                // Jika data dosen sudah ada, perbarui
                if ($pegawai) {

                    // ambil id dari unitkerja berdasarkan homebase $dosenData['homebase']
                    $unitKerja = UnitKerja::firstOrCreate(['nama_unit' => $dosenData['homebase']]);
                    $dosenData['unit_kerja_id'] = $unitKerja->id;

                    // return response()->json($pegawai);
                    $pegawai->update($dosenData);
                    $dosen = Dosen::where('nip', $dosenData['nip'])->first();

                    if ($dosen) {
                        // Update kolom-kolom yang diinginkan pada objek Dosen
                        $dosen->update([
                            'nidn' => $dosenData['nidn'],
                            'homebase' => $dosenData['homebase']
                        ]);
                    } else {
                        // Jika objek Dosen belum ada, buat objek baru dan simpan ke database
                        Dosen::create([
                            'nidn' => $dosenData['nidn'],
                            'nip' => $dosenData['nip'],
                            'homebase' => $dosenData['homebase']
                        ]);
                    }
                } else {
                    // Jika tidak, buat data dosen baru
                    $pegawai['id'] = Str::uuid();
                    $unitKerja = UnitKerja::firstOrCreate(['nama_unit' => $dosenData['homebase']]);
                    $dosenData['unit_kerja_id'] = $unitKerja->id;

                    // return response()->json($unitKerja);

                    Pegawai::create($dosenData);
                    Dosen::create([
                        'nidn' => $dosenData['nidn'],
                        'nip' => $dosenData['nip'],
                        'homebase' => $dosenData['homebase']
                    ]);
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data dosen berhasil disinkronkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // fungsi getdataperiode
    function getDataPeriode(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                'limit' => 10000,
            ];

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data periode
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dataperiode', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data periode ke dalam tabel Periode
            foreach ($data as $periodeData) {
                $periode = Periode::where('kode_periode', $periodeData['kode_periode'])->first();

                // Jika data periode sudah ada, perbarui
                if ($periode) {
                    $periode->update($periodeData);
                } else {
                    // Jika tidak, buat data periode baru
                    $periodeData['id'] = Str::uuid();
                    Periode::create($periodeData);
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data periode berhasil disinkronkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // fungsi get data kelas kuliah
    // function getDataKelasKuliah(Request $request)
    // {
    //     try {
    //         // Ambil access token yang sudah disimpan
    //         $accessToken = $request->get("access_token");
    //         $programstudi = $request->get("programstudi");
    //         $periodeakademik = $request->get("periodeakademik");

    //         // Jika access token tidak ada, kembalikan pesan kesalahan
    //         if (!$accessToken) {
    //             return response()->json(['error' => 'Access token tidak tersedia'], 500);
    //         }

    //         // Parameter form yang akan dikirim
    //         $formData = [
    //             'limit' => 10000,
    //             'programstudi' => $programstudi,
    //             'periodeakademik' => $periodeakademik,
    //         ];

    //         // Buat instance dari Guzzle Client
    //         $client = new Client();

    //         // Menggunakan access token untuk request mendapatkan data kelas kuliah
    //         $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/kelaskuliah', [
    //             'query' => $formData,
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
    //             ]
    //         ]);

    //         // Mendapatkan body respons sebagai string
    //         $body = $response->getBody()->getContents();

    //         // Mendapatkan data dari body respons
    //         $data = json_decode($body, true);

    //         // Simpan data kelas kuliah ke dalam tabel KelasKuliah
    //         foreach ($data as $kelasKuliahData) {
    //             $kelasKuliah = KelasKuliah::where('kelasid', $kelasKuliahData['kelasid'])
    //                 ->where('nip', $kelasKuliahData['nip'])
    //                 ->first();

    //             // Jika data kelas kuliah sudah ada, perbarui
    //             if ($kelasKuliah) {
    //                 $kelasKuliah->update($kelasKuliahData);
    //             } else {
    //                 // Jika tidak, buat data kelas kuliah baru
    //                 $kelasKuliahData['id'] = Str::uuid();
    //                 KelasKuliah::create($kelasKuliahData);
    //             }
    //         }
    //         // Tampilkan data yang diperoleh dari request
    //         return response()->json(['message' => 'Data kelas kuliah berhasil disinkronkan', 'data' => json_decode($body, true)]);
    //     } catch (Exception $e) {
    //         // Tangani kesalahan jika permintaan gagal
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }



    // getDataKelasKuliah
    function getDataKelasKuliah(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            $formData = [];

            if ($request->programstudi != null) {
                $formData['programstudi'] = $request->get('programstudi');
            }

            if ($request->periodeakademik != null) {
                $formData['periodeakademik'] = $request->get('periodeakademik');
            }

            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data kelas kuliah
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/kelaskuliah', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data kelas kuliah ke dalam tabel KelasKuliah
            $count_update = 0;
            $count_insert = 0;
            $dataupdate = [];
            foreach ($data as $kelasKuliahData) {
                $kelasKuliah = KelasKuliah::where('periodeakademik', $kelasKuliahData['periodeakademik'])
                    ->where('programstudi', $kelasKuliahData['programstudi'])
                    ->where('kodemk', $kelasKuliahData['kodemk'])
                    ->where('namakelas', $kelasKuliahData['namakelas'])
                    ->where('nip', $kelasKuliahData['nip'])
                    ->where('kelasid', $kelasKuliahData['kelasid'])
                    ->first();
                // Jika data kelas kuliah sudah ada, perbarui
                if ($kelasKuliah) {
                    $kelasKuliah->update($kelasKuliahData);
                    $dataupdate[] = $kelasKuliahData;
                    $count_update++;
                } else {
                    // Jika tidak, buat data kelas kuliah baru
                    $kelasKuliahData['id'] = Str::uuid();
                    KelasKuliah::create($kelasKuliahData);
                    $count_insert++;
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(
                [
                    'message' => 'Data kelas kuliah berhasil disinkronkan,' . $count_update . " data berhasil diperbarui dan " . $count_insert . " data baru",
                    'data' => json_decode($body, true),
                    'data_update' => $dataupdate
                ]
            );
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getDataJadwalKuliah(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            $formData = [];

            if ($request->programstudi != null) {
                $formData['programstudi'] = $request->get('programstudi');
            }

            if ($request->periode != null) {
                $formData['periode'] = $request->get('periode');
            }

            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data kelas kuliah
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/jadwalperkuliahan', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data kelas kuliah ke dalam tabel KelasKuliah
            $count_update = 0;
            $count_insert = 0;
            $dataupdate = [];
            foreach ($data as $jadwalKuliahData) {
                $jadwalKuliah = JadwalPerkuliahan::where('periode', $jadwalKuliahData['periode'])
                    ->where('programstudi', $jadwalKuliahData['programstudi'])
                    ->where('kodemk', $jadwalKuliahData['kodemk'])
                    ->where('nip', $jadwalKuliahData['nip'])
                    ->where('kelasid', $jadwalKuliahData['kelasid'])
                    ->where('jadwalid', $jadwalKuliahData['jadwalid'])
                    ->first();
                // Jika data kelas kuliah sudah ada, perbarui
                if ($jadwalKuliah) {
                    $jadwalKuliah->update($jadwalKuliahData);
                    $dataupdate[] = $jadwalKuliahData;
                    $count_update++;
                } else {
                    // Jika tidak, buat data kelas kuliah baru
                    $jadwalKuliahData['id'] = Str::uuid();
                    JadwalPerkuliahan::create($jadwalKuliahData);
                    $count_insert++;
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(
                [
                    'message' => 'Data jadwal kuliah berhasil disinkronkan,' . $count_update . " data berhasil diperbarui dan " . $count_insert . " data baru",
                    'data' => json_decode($body, true),
                    'data_update' => $dataupdate
                ]
            );
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getDataPresensiKuliah(Request $request)
    {
        set_time_limit(1000);

        // Validasi request
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'programstudi' => 'required',
            'periode' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respons error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->input("access_token");

            // Validasi access token
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Ambil data form jika limit tidak null
            $formData = [];
            if ($request->input('limit') != null) {
                $formData['limit'] = $request->input('limit');
            }

            // Hapus data PresensiKuliah berdasarkan periode dan program studi
            PresensiKuliah::where('periodeakademik', $request->input('periode'))
                ->where('programstudi', 'ilike', '%' . $request->input('programstudi') . '%')
                ->delete();

            // Ambil KelasKuliah berdasarkan periode dan program studi
            $kelasKuliah = KelasKuliah::where('periodeakademik', $request->input('periode'))
                ->where('programstudi', 'ilike', '%' . $request->input('programstudi') . '%')
                ->get();

            $count_insert = 0;

            // Iterasi untuk mengakses data kelas kuliah
            foreach ($kelasKuliah as $kls) {
                $formData['periodeakademik'] = $kls->periodeakademik;
                $formData['kodemk'] = $kls->kodemk;
                $formData['kelas'] = $kls->namakelas;

                // Buat instance dari Guzzle Client
                $client = new Client();

                try {
                    // Request data presensi menggunakan access token
                    $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/presensi', [
                        'query' => $formData,
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken
                        ]
                    ]);

                    // Ambil body response sebagai string
                    $body = $response->getBody()->getContents();

                    // Decode data dari body response
                    $data = json_decode($body, true);

                    // Jika data tidak null, lakukan penyimpanan batch
                    if ($data != null) {
                        $chunks = array_chunk($data, 1000); // Misal setiap chunk berisi 1000 data
                        foreach ($chunks as $chunk) {
                            // generete uuid for id
                            foreach ($chunk as $key => $value) {
                                $chunk[$key]['id'] = Str::uuid();
                            }

                            PresensiKuliah::insert($chunk);
                            $count_insert += count($chunk);
                        }
                    }
                } catch (RequestException $e) {
                    // Tangani kesalahan jika request gagal
                    if ($e->getResponse() && $e->getResponse()->getStatusCode() == 404) {
                        // Tangani respons 404
                        $errors[] = [
                            'error' => 'Data tidak ditemukan (404)'
                        ];
                    } else {
                        // Tangani kesalahan lain
                        $errors[] = [
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }

            // Tampilkan response JSON dengan pesan sukses dan jumlah data yang berhasil disinkronkan
            return response()->json([
                'message' => 'Data presensi berhasil disinkronkan. ' . $count_insert . ' data baru disimpan.',
            ]);
        } catch (Exception $e) {
            // Tangani kesalahan jika terjadi exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // getDataKrs
    function getDataKrs(Request $request)
    {
        set_time_limit(1000);
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            $formData = [];

            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }


            // kelas kuliah
            $kelasKuliah = KelasKuliah::where('periodeakademik', $request->periodeakademik)
                ->where('programstudi', $request->programstudi)
                // ->where('nip', 'IF397')
                ->get();

            // return response()->json($kelasKuliah);
            $count_update = 0;
            $count_insert = 0;
            $dataupdate = [];

            // pengulangan untuk mengakses krs
            foreach ($kelasKuliah as $key => $kelas) {
                $formData['idperiode'] = $kelas->periodeakademik;
                $formData['namakelas'] = $kelas->namakelas;
                $formData['idmk'] = $kelas->kodemk;
                $formData['krsdiajukan'] = 'Ya';
                $formData['krsdisetujui'] = 'Ya';
                // Buat instance dari Guzzle Client
                $client = new Client();

                try {
                    // Menggunakan access token untuk request mendapatkan data kelas kuliah
                    $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/krsmahasiswa', [
                        'query' => $formData,
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                        ]
                    ]);

                    // Mendapatkan body respons sebagai string
                    $body = $response->getBody()->getContents();
                    // return response()->json(json_decode($body, true));

                    // Mendapatkan data dari body respons
                    $data = json_decode($body, true);

                    if ($data != null) {
                        foreach ($data as $krsData) {

                            $krs = Krs::where('idperiode', $krsData['idperiode'])
                                ->where('namakelas', $krsData['namakelas'])
                                ->where('nim', $krsData['nim'])
                                ->where('idmk', $krsData['idmk'])
                                ->first();

                            // Jika data krs sudah ada, perbarui
                            if ($krs) {
                                $krs->update($krsData);
                                $dataupdate[] = $krsData;
                                $count_update++;
                            } else {
                                // Jika tidak, buat data krs baru
                                $krsData['id'] = Str::uuid();
                                Krs::create($krsData);
                                $count_insert++;
                            }
                        }
                    }
                } catch (RequestException $e) {
                    // Menangani kesalahan jika permintaan gagal
                    if ($e->getResponse() && $e->getResponse()->getStatusCode() == 404) {
                        // Menangani respons 404
                        $errors[] = [
                            'kelas' => $kelas,
                            'error' => 'Data tidak ditemukan (404)'
                        ];
                    } else {
                        // Menangani kesalahan lain
                        $errors[] = [
                            'kelas' => $kelas,
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }

            // Tampilkan data yang diperoleh dari request
            return response()->json(
                [
                    'message' => 'Data krs berhasil disinkronkan,' . $count_update . " data berhasil diperbarui dan " . $count_insert . " data baru",
                    'data' => json_decode($body, true),
                    'data_update' => $dataupdate
                ]
            );
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // function getDataKrs(Request $request)
    // {
    //     set_time_limit(1000);
    //     try {
    //         $accessToken = $request->get("access_token");
    //         $formData = [];
    //         if ($request->limit != null) {
    //             $formData['limit'] = $request->get('limit');
    //         }

    //         if (!$accessToken) {
    //             return response()->json(['error' => 'Access token tidak tersedia'], 500);
    //         }

    //         $kelasKuliah = KelasKuliah::where('programstudi', $request->programstudi)
    //             ->get();

    //         $client = new Client();
    //         $promises = [];
    //         $count_update = 0;
    //         $count_insert = 0;
    //         $dataupdate = [];
    //         $errors = [];

    //         foreach ($kelasKuliah as $kelas) {
    //             $formData['idperiode'] = $kelas->periodeakademik;
    //             $formData['namakelas'] = $kelas->namakelas;
    //             $formData['idmk'] = $kelas->kodemk;
    //             $formData['krsdiajukan'] = 'Ya';
    //             $formData['krsdisetujui'] = 'Ya';

    //             $promises[] = $client->getAsync('https://unpas.siakadcloud.com/live/krsmahasiswa', [
    //                 'query' => $formData,
    //                 'headers' => [
    //                     'Authorization' => 'Bearer ' . $accessToken
    //                 ]
    //             ])->then(
    //                 function ($response) use (&$count_update, &$count_insert, &$dataupdate, $kelas) {
    //                     $body = $response->getBody()->getContents();
    //                     $data = json_decode($body, true);

    //                     if ($data != null) {
    //                         foreach ($data as $krsData) {
    //                             $krs = Krs::where('idperiode', $krsData['idperiode'])
    //                                 ->where('namakelas', $krsData['namakelas'])
    //                                 ->where('nim', $krsData['nim'])
    //                                 ->where('idmk', $krsData['idmk'])
    //                                 ->first();

    //                             if ($krs) {
    //                                 $krs->update($krsData);
    //                                 $dataupdate[] = $krsData;
    //                                 $count_update++;
    //                             } else {
    //                                 $krsData['id'] = Str::uuid();
    //                                 Krs::create($krsData);
    //                                 $count_insert++;
    //                             }
    //                         }
    //                     }
    //                 },
    //                 function ($exception) use (&$errors, $kelas) {
    //                     if ($exception->getResponse() && $exception->getResponse()->getStatusCode() == 404) {
    //                         $errors[] = [
    //                             'kelas' => $kelas,
    //                             'error' => 'Data tidak ditemukan (404)'
    //                         ];
    //                     } else {
    //                         $errors[] = [
    //                             'kelas' => $kelas,
    //                             'error' => $exception->getMessage()
    //                         ];
    //                     }
    //                 }
    //             );
    //         }

    //         // Wait for all the promises to settle
    //         Utils::all($promises)->wait();

    //         return response()->json([
    //             'message' => 'Data krs berhasil disinkronkan, ' . $count_update . ' data berhasil diperbarui dan ' . $count_insert . ' data baru',
    //             'data_update' => $dataupdate,
    //             'errors' => $errors
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    function getAllDataKrs(Request $request)
    {
        set_time_limit(5000);
        try {
            $accessToken = $request->get("access_token");
            $formData = [];
            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            $kelasKuliah = KelasKuliah::where('periodeakademik', $request->periodeakademik)
                ->where('programstudi', $request->programstudi)
                ->get();

            $client = new Client();
            $promises = [];
            $count_update = 0;
            $count_insert = 0;
            $dataupdate = [];
            $errors = [];

            foreach ($kelasKuliah as $kelas) {
                $formData['idperiode'] = $kelas->periodeakademik;
                $formData['namakelas'] = $kelas->namakelas;
                $formData['idmk'] = $kelas->kodemk;
                $formData['krsdiajukan'] = 'Ya';
                $formData['krsdisetujui'] = 'Ya';

                $promises[] = $client->getAsync('https://unpas.siakadcloud.com/live/krsmahasiswa', [
                    'query' => $formData,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken
                    ]
                ])->then(
                    function ($response) use (&$count_update, &$count_insert, &$dataupdate, $kelas) {
                        $body = $response->getBody()->getContents();
                        $data = json_decode($body, true);

                        if ($data != null) {
                            foreach ($data as $krsData) {
                                $krs = Krs::where('idperiode', $krsData['idperiode'])
                                    ->where('namakelas', $krsData['namakelas'])
                                    ->where('nim', $krsData['nim'])
                                    ->where('idmk', $krsData['idmk'])
                                    ->first();

                                if ($krs) {
                                    $krs->update($krsData);
                                    $dataupdate[] = $krsData;
                                    $count_update++;
                                } else {
                                    $krsData['id'] = Str::uuid();
                                    Krs::create($krsData);
                                    $count_insert++;
                                }
                            }
                        }
                    },
                    function ($exception) use (&$errors, $kelas) {
                        if ($exception->getResponse() && $exception->getResponse()->getStatusCode() == 404) {
                            $errors[] = [
                                'kelas' => $kelas,
                                'error' => 'Data tidak ditemukan (404)'
                            ];
                        } else {
                            $errors[] = [
                                'kelas' => $kelas,
                                'error' => $exception->getMessage()
                            ];
                        }
                    }
                );
            }

            // Wait for all the promises to settle
            Utils::all($promises)->wait();

            return response()->json([
                'message' => 'Data krs berhasil disinkronkan, ' . $count_update . ' data berhasil diperbarui dan ' . $count_insert . ' data baru',
                'data_update' => $dataupdate,
                'errors' => $errors
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // getDataAKM
    function getDataAKM(Request $request)
    {
        set_time_limit(1000);
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            $formData = [];

            if ($request->limit != null) {
                $formData['limit'] = $request->get('limit');
            }

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Mahasiswa
            $mahasiswa = Mahasiswa::where('programstudi', $request->programstudi)
                // ->where('periodemasuk', $request->periodemasuk)
                ->where(function ($query) {
                    $query->where('periodemasuk', '20151')
                        ->orWhere('periodemasuk', '20141')
                        ->orWhere('periodemasuk', '20131')
                        ->orWhere('periodemasuk', '20121')
                        ->orWhere('periodemasuk', '20111')
                        ->orWhere('periodemasuk', '20101');
                    // ->orWhere('periodemasuk', '20091');
                    // ->orWhere('periodemasuk', '20081')
                })
                ->where('statusmahasiswa', 'Aktif')
                ->get();

            // return response()->json($mahasiswa);
            $count_update = 0;
            $count_insert = 0;
            $dataupdate = [];

            // pengulangan untuk mengakses krs
            foreach ($mahasiswa as $key => $mhs) {
                $formData['nim'] = $mhs->nim;
                // Buat instance dari Guzzle Client
                $client = new Client();

                try {
                    // Menggunakan access token untuk request mendapatkan data kelas kuliah
                    $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/akmmahasiswa', [
                        'query' => $formData,
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                        ]
                    ]);

                    // Mendapatkan body respons sebagai string
                    $body = $response->getBody()->getContents();
                    // return response()->json(json_decode($body, true));

                    // Mendapatkan data dari body respons
                    $data = json_decode($body, true);

                    if ($data != null) {
                        foreach ($data as $akmData) {
                            // $akm = AKM::where('nim', $akmData['nim'])
                            //     ->where('idperiode', $akmData['idperiode'])
                            //     ->first();

                            // // Jika data krs sudah ada, perbarui
                            // if ($akm) {
                            //     $akm->update($akmData);
                            //     $dataupdate[] = $akmData;
                            //     $count_update++;
                            // } else {
                            // Jika tidak, buat data krs baru
                            $akmData['id'] = Str::uuid();
                            AKM::create($akmData);
                            $count_insert++;
                            // }
                        }
                    }
                } catch (RequestException $e) {
                    // Menangani kesalahan jika permintaan gagal
                    if ($e->getResponse() && $e->getResponse()->getStatusCode() == 404) {
                        // Menangani respons 404
                        $errors[] = [
                            'mahasiswa' => $mhs,
                            'error' => 'Data tidak ditemukan (404)'
                        ];
                    } else {
                        // Menangani kesalahan lain
                        $errors[] = [
                            'mahasiswa' => $mhs,
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }

            // Tampilkan data yang diperoleh dari request
            return response()->json(
                [
                    'message' => 'Data akm berhasil disinkronkan,' . $count_update . " data berhasil diperbarui dan " . $count_insert . " data baru",
                    'data' => json_decode($body, true),
                    'data_update' => $dataupdate
                ]
            );
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // hitung presensi
    function hitungPresensi(Request $request)
    {
        // validate nim dan periode
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'periode' => 'required'
        ]);

        // jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            $listKRS = Krs::where('nim', $request->nim)
                ->where('idperiode', $request->periode)
                ->get();

            // return response()->json($listKRS);

            // Iterasi setiap KRS dan hitung jumlah presensi
            foreach ($listKRS as $krs) {
                $krs->hitungJumlahPresensi();
            }

            return response()->json(['message' => 'Presensi berhasil dihitung']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
