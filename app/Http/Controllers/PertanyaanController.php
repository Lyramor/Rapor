<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Periode;
use App\Models\ProgramStudi;
use App\Models\Rapor;
use Illuminate\Auth\Events\Validated;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
    //show
    public function show($id, Request $request)
    {
        // $id to string
        $id = (string) $id;
        try {
            $soal = Soal::find($id);

            // // pernyataan paginate and orderby no_pertanyaan where soal_id
            $dataPertanyaan = Pertanyaan::with('soal')->orderBy('no_pertanyaan', 'asc')
                ->where('soal_id', $id)
                ->paginate(10);

            $total = $dataPertanyaan->total(); // Mendapatkan total data

            return view('kuesioner.banksoal.listpertanyaan', [
                'data' => $soal,
                'data1' => $dataPertanyaan,
                'total' => $total,
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    // create
    public function create($id, Request $request)
    {
        // $id to string
        $id = (string) $id;
        try {
            $soal = Soal::find($id);
            //cek apakah request kosong
            if ($request->has('periodeakademik') && $request->has('programstudi')) {
                $periodeakademik = $request->periodeakademik;
                $programstudi = $request->programstudi;
            } else {
                //dapatkan data kode_periode dari model periode paling akhir
                // $periode = Periode::orderBy('kode_periode', 'desc')->pluck('kode_periode')->first();

                // dapatkan 10 data paling akhir dari Periode
                $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

                // dapatkan data dari model Program Studi
                $daftar_programstudi = ProgramStudi::all();
                $periode = 20231;

                $dataRapor = Rapor::with('dosen')
                    ->where('periode_rapor', $periode)
                    ->paginate(10);

                $total = $dataRapor->total(); // Mendapatkan total data

                // return response()->json($dataRapor);
                return view('kuesioner.banksoal.pertanyaan-create', [
                    'data' => $soal,
                    'data1' => $dataRapor,
                    'daftar_periode' => $daftar_periode,
                    'daftar_programstudi' => $daftar_programstudi,
                    'total' => $total,
                ]);
            }

            return view('kuesioner.banksoal.pertanyaan-create');
        } catch (\Throwable $th) {
            return back();
        }
    }

    // store
    public function store(Request $request)
    {
        // dump data request
        // dd($request->all());
        // // Validated
        try {
            $validatedData = $request->validate([
                'no_pertanyaan' => 'required|integer',
                'jenis_pertanyaan' => 'required|string',
                'pertanyaan' => 'required|string',
                'soal_id' => 'required|string',
            ]);
            $pertanyaan = new Pertanyaan;
            $pertanyaan->no_pertanyaan = $request->no_pertanyaan;
            $pertanyaan->jenis_pertanyaan = $request->jenis_pertanyaan;
            $pertanyaan->pertanyaan = $request->pertanyaan;
            $pertanyaan->soal_id = $request->soal_id;

            if ($request->jenis_pertanyaan == 'range_nilai') {
                $pertanyaan->scale_range_min = $request->scale_range_min;
                $pertanyaan->scale_range_max = $request->scale_range_max;
                $pertanyaan->scale_text_min = $request->scale_text_min;
                $pertanyaan->scale_text_max = $request->scale_text_max;
                // return back()->with('message', 'Pertanyaan range nilai berhasil ditambahkan');
            }

            $pertanyaan->save();
            return back()->with('message', 'Pertanyaan berhasil ditambahkan');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, kembalikan response error
            return back()->with('message', "Gagal menyimpan data pertanyaan: " . $e);
        }


        // try {
        //     $pertanyaan = new Pertanyaan;
        //     $pertanyaan->no_pertanyaan = $request->no_pertanyaan;
        //     $pertanyaan->jenis_pertanyaan = $request->jenis_pertanyaan;
        //     $pertanyaan->pertanyaan = $request->pertanyaan;
        //     $pertanyaan->soal_id = $request->soal_id;
        //     $pertanyaan->save();

        //     return redirect()->route('kuesioner.banksoal.list-pertanyaan', $request->soal_id)->with('success', 'Pertanyaan berhasil ditambahkan');
        // } catch (\Throwable $th) {
        //     return back()->with('error', 'Pertanyaan gagal ditambahkan');
        // }
    }
}
