<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\ProgramStudi;
use App\Models\Rapor;

class KuesionerController extends Controller
{
    //index
    public function dashboard(Request $request)
    {
        // jika selected_role admin maka tampilkan halaman dashboard jika pegawai redirect ke penilaian
        if (session('selected_role') == 'Super Admin' || session('selected_role') == 'Pimpinan Fakultas') {
            //cek apakah request kosong
            if ($request->has('periodeakademik') && $request->has('programstudi')) {
                $periodeakademik = $request->periodeakademik;
                $programstudi = $request->programstudi;
            } else {
                //dapatkan data kode_periode dari model periode paling akhir
                $periode = Periode::orderBy('kode_periode', 'desc')->pluck('kode_periode')->first();

                // dapatkan 10 data paling akhir dari Periode
                $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

                // dapatkan data dari model Program Studi
                $daftar_programstudi = ProgramStudi::all();
                // $periode = 20231;

                $dataRapor = Rapor::with('dosen')
                    ->where('periode_rapor', $periode)
                    ->paginate(10);

                $total = $dataRapor->total(); // Mendapatkan total data

                // return response()->json($dataRapor);
                return view('kuesioner.dashboard', [
                    'data' => $dataRapor,
                    'daftar_periode' => $daftar_periode,
                    'daftar_programstudi' => $daftar_programstudi,
                    'total' => $total,
                ]);
            }
        } else if (session('selected_role') == 'Pegawai') {
            return redirect()->route('kuesioner.penilaian');
        } else {
            return redirect()->route('login');
        }
    }
}
