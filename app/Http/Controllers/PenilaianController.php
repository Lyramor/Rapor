<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Penilaian;
use App\Models\Soal;
use Illuminate\Http\Request;
use App\Models\SoalKuesionerSDM;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    //index
    public function index()
    {
        $responden = Responden::with(['kuesionerSDM', 'pegawai', 'penilaian'])
            ->where('pegawai_nip', auth()->user()->pegawai->nip)
            ->where('status_selesai', false)
            ->get();
        
            // $nohp = auth()->user()->pegawai->nip;
            // dd($nohp);

        // return response()->json($responden);
        return view('kuesioner.penilaian.index', [
            'data_kuisioner' => $responden
        ]);
    }

    public function riwayat()
    {
        $responden = Responden::with(['kuesionerSDM', 'pegawai', 'penilaian'])
            ->where('pegawai_nip',  auth()->user()->pegawai->nip)
            ->where('status_selesai', true)
            ->get();

        // return response()->json($responden);
        return view('kuesioner.penilaian.riwayat', [
            'data_kuisioner' => $responden
        ]);
    }

    // generate penilaian
    public function mulaiPenilaian($id)
    {
        $responden = Responden::with(['kuesionerSDM', 'pegawai', 'penilaian'])
            ->where('pegawai_nip', auth()->user()->pegawai->nip)
            ->where('id', $id)
            ->first();

        // tampilkan responden id dari $responden
        $responden_id = $responden->id;
        $kuesioner_sdm_id = $responden->kuesioner_sdm_id;

        // return responden json format
        // return response()->json($responden);

        // cek jika penilaian sudah di generate
        if ($responden->penilaian->count() == 0) {
            // echo "penilaian belum di generate";
            $this->generatePertanyaan($kuesioner_sdm_id, $responden_id);
            $responden->refresh();
        }

        return view('kuesioner.penilaian.penilaian', [
            'data' => $responden
        ]);
    }

    // fungsi generate pertanyaan
    private function generatePertanyaan($kuesioner_sdm_id, $responden_id)
    {
        // ambil dulu kuisoner_sdm_id dari model Responden where id
        // $kuesioner_sdm_id = $kuesioner_sdm_id;

        // ambil soal_id dari model SoalKuesionerSDM where kuesioner_sdm_id
        $daftarsoal = SoalKuesionerSDM::with('soal')->where('kuesioner_sdm_id', $kuesioner_sdm_id)->get();

        // Iterasi melalui data_soal
        foreach ($daftarsoal as $soal) {
            // Iterasi melalui pertanyaan pada setiap soal
            foreach ($soal['soal']['pertanyaan'] as $pertanyaan) {
                // buat data penilaian dengan $id dan  $pertanyaan['id'];
                $penilaian = new Penilaian();
                $penilaian->responden_id = $responden_id;
                $penilaian->pertanyaan_id = $pertanyaan['id'];
                $penilaian->kuesioner_sdm_id = $kuesioner_sdm_id;
                $penilaian->unsur_penilaian_id = $soal['unsur_penilaian_id'];
                $penilaian->save();
            }
        }
    }

    // store penilaian
    public function store(Request $request)
    {
        // tampilkan semua request
        // dd($request->all());
        // return response()->json($request->all());

        try {
            // Mendapatkan responden_id dari data
            $respondenId = $request->input('responden_id');
            // $kuesioner_sdm_id = $request->input('kuesioner_sdm_id');

            // Mengambil semua jawaban dari input
            $jawaban = $request->except('_token', 'responden_id', 'kuesioner_sdm_id');

            // Memulai transaksi database
            DB::beginTransaction();

            // Loop untuk setiap jawaban
            foreach ($jawaban as $pertanyaanId => $nilai) {
                // Cari entri Penilaian yang sesuai
                $penilaian = Penilaian::where('responden_id', $respondenId)
                    ->where('pertanyaan_id', $pertanyaanId)
                    ->first();

                // Jika penilaian sudah ada, update nilai
                if ($penilaian) {
                    $penilaian->update([
                        'jawaban_numerik' => is_numeric($nilai) ? $nilai : $penilaian->jawaban_numerik,
                        'jawaban_essay' => !is_numeric($nilai) ? json_encode($nilai) : $penilaian->jawaban_essay,
                    ]);
                }
            }

            // ubah status_selesai responden menjadi true
            Responden::where('id', $respondenId)->update(['status_selesai' => true]);

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Setelah menyimpan, Anda juga bisa melakukan sesuatu, seperti redirect atau memberikan pesan
            // echo ("Data penilaian berhasil disimpan.");
            return redirect()->route('kuesioner.penilaian')->with('message', 'Data penilaian berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Handle error, misalnya redirect dengan pesan error
            // echo ("Terjadi kesalahan: " . $e->getMessage());
            return redirect()->route('kuesioner.penilaian')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
