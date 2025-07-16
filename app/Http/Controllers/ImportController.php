<?php

namespace App\Http\Controllers;

use App\Models\KuesionerSDM;
use Illuminate\Http\Request;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rapor;
use Maatwebsite\Excel\Row;
use App\Models\Pegawai;
use App\Models\Pertanyaan;
use App\Models\Soal;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function importRaporKinerja1(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
                array_shift($data[0]);
                array_shift($data[0]);

                foreach ($data[0] as $row) {
                    //update data Rapor
                    $rapor = Rapor::where('periode_rapor', $row[1])
                        //ilike %dosen_nip%
                        ->where('dosen_nip', 'ilike', '%' . $row[2] . '%')
                        ->where('programstudi', $row[5])
                        ->first();

                    // dd($rapor);
                    // print_r($rapor);

                    if ($rapor) {
                        $rapor->bkd_total = $row[6];
                        $rapor->edom_materipembelajaran = $row[7];
                        $rapor->edom_pengelolaankelas = $row[8];
                        $rapor->edom_prosespengajaran = $row[9];
                        $rapor->edom_penilaian = $row[10];
                        $rapor->edasep_atasan = $row[11];
                        $rapor->edasep_sejawat = $row[12];
                        $rapor->edasep_bawahan = $row[13];
                        $rapor->save();
                    } else {
                        //insert data Rapor
                        // $rapor = new Rapor();
                        // $rapor->periode_rapor = $row[1];
                        // $rapor->dosen_nip = $row[2];
                        // $rapor->programstudi = $row[5];
                        // $rapor->bkd_total = $row[6];
                        // $rapor->edom_materipembelajaran = $row[7];
                        // $rapor->edom_pengelolaankelas = $row[8];
                        // $rapor->edom_prosespengajaran = $row[9];
                        // $rapor->edom_penilaian = $row[10];
                        // $rapor->edasep_atasan = $row[11];
                        // $rapor->edasep_sejawat = $row[12];
                        // $rapor->edasep_bawahan = $row[13];
                        // $rapor->save();
                    }
                }
                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }
        return redirect()->back()->with('message', $message);
    }

    public function importPertanyaan(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            // 'soal_id' => 'required'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                //buat dulu soal
                $soal = new Soal();
                foreach ($data[0] as $row) {
                    if ($row[0] == 'Nama Kelompok Soal') {
                        $soal->nama_soal = $row[1];
                    }
                    if ($row[0] == 'Deskripsi Soal') {
                        $soal->keterangan = $row[1];
                    }
                    if (empty($row[0]) || $row[0] == '' || $row[0] == null) {
                        break;
                    }
                }

                $soal->save();

                // get soal id
                $validasi['soal_id'] = $soal->id;

                array_shift($data[0]);
                array_shift($data[0]);
                array_shift($data[0]);

                // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
                array_shift($data[0]);

                // return response()->json([
                //     'data' => $data
                // ]);

                $pertanyaans = [];
                $count = 1;

                foreach ($data[0] as $row) {
                    $pertanyaan = [];

                    if (empty($row[0]) || $row[0] == '' || $row[0] == null || $row[0] == 'Catatan:') {
                        break;
                    } else {

                        if ($row[1] == "R") {
                            $pertanyaan = [
                                'jenis_pertanyaan' => "range_nilai",
                                'pertanyaan' => $row[2],
                                'scale_range_min' => $row[3],
                                'scale_range_max' => $row[4],
                                'scale_text_min' => $row[5],
                                'scale_text_max' => $row[6]
                            ];
                        } elseif ($row[1] == "E") {
                            $pertanyaan = [
                                'jenis_pertanyaan' => "essay",
                                'pertanyaan' => $row[2]
                            ];
                        } else {
                            return response()->json([
                                'message' => 'Jenis pertanyaan tidak ditemukan pada soal nomor ' . $count
                            ], 404);
                        }

                        $pertanyaan['soal_id'] = $validasi['soal_id'];
                        $pertanyaan['no_pertanyaan'] = $row[0];

                        $pertanyaans[] = $pertanyaan;
                    }
                    $count++;
                }


                foreach ($pertanyaans as $pertanyaan) {
                    Pertanyaan::create($pertanyaan);
                }

                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }
        return redirect()->back()->with('message', $message);
    }

    public function importKuesionerSDM(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            // 'soal_id' => 'required'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                $listKuesionerSDM = [];
                $count = 1;

                // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
                array_shift($data[0]);

                foreach ($data[0] as $row) {
                    $kuesionerSDM = [];

                    if (empty($row[0]) || $row[0] == '' || $row[0] == null) {
                        break;
                    } else {

                        if ($row[4] == 'A') {
                            $kuesionerSDM = [
                                'jenis_kuesioner' => "Atasan",
                            ];
                        } elseif ($row[4] == 'S') {
                            $kuesionerSDM = [
                                'jenis_kuesioner' => "Sejawat",
                            ];
                        } elseif ($row[4] == 'B') {
                            $kuesionerSDM = [
                                'jenis_kuesioner' => "Bawahan",
                            ];
                        } else {
                            $message = "Upload Gagal : Jenis kuesioner tidak ditemukan pada daftar nomor " . $count;
                            return redirect()->back()->with('message', $message);
                        }

                        $pegawai = Pegawai::where('nip', $row[2])
                        ->orWhere('nama', 'ilike', '%' . $row[3] . '%')
                        ->first();
                        if ($pegawai) {
                            $kuesionerSDM['subjek_penilaian'] = $pegawai->nip;
                        } else {
                            $message = "Upload Gagal : Pegawai dengan nip " . $row[2] . " tidak ditemukan pada daftar nomor " . $count;
                            return redirect()->back()->with('message', $message);
                        }

                        $kuesionerSDM['kode_periode'] = $row[0];
                        $kuesionerSDM['nama_kuesioner'] = $row[1];
                        $kuesionerSDM['jadwal_kegiatan_mulai'] =  Carbon::createFromTimestamp(($row[5] - 25569) * 86400)->format('Y-m-d');
                        $kuesionerSDM['jadwal_kegiatan_selesai'] = Carbon::createFromTimestamp(($row[6] - 25569) * 86400)->format('Y-m-d');
                        // $kuesionerSDM['jadwal_kegiatan_selesai'] = $row[6];

                        $listKuesionerSDM[] = $kuesionerSDM;
                    }
                    $count++;
                }

                // return response()->json([
                //     'data' => $listKuesionerSDM
                // ]);
                foreach ($listKuesionerSDM as $kuesionerSDM) {
                    KuesionerSDM::create($kuesionerSDM);
                }

                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }
        return redirect()->back()->with('message', $message);
    }
}
