<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Rapor;
use App\Models\KelasKuliah;
use App\Models\Periode;
use App\Models\ProgramStudi;

class RaporController extends Controller
{
    function index()
    {
        $data = [
            'title' => 'RAPOR KINERJA INDIVIDU',
            'subtitle' => 'SEMESTER GANJIL 2023/2024',
            'date' => date('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.rapor',);
        // $pdf = Pdf::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
    }

    function dashboard(Request $request)
    {
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
            return view('rapor-kinerja.index', [
                'data' => $dataRapor,
                'daftar_periode' => $daftar_periode,
                'daftar_programstudi' => $daftar_programstudi,
                'total' => $total,
            ]);
        }

        return view('rapor-kinerja.index');
    }

    // fungsi generated data model rapor berdasarkan periode dan program studi
    function generateDataRapor(Request $request)
    {
        // ambil data dari post request
        $periodeakademik = $request->periodeakademik;
        $programstudi = $request->programstudi;

        //dapatkan kode nip dosen dari kelas kuliah berdasarkan periode dan prodi dan grouping berdasarkan nip
        $dosens = KelasKuliah::where('periodeakademik', $periodeakademik)
            ->where('programstudi', $programstudi)
            ->select('nip') // Pilih kolom nip
            ->groupBy('nip')
            ->get();

        $dataRapor = [];
        // buat data rapor berdasarkan data dosens 
        foreach ($dosens as $dosen) {

            // jika data nip dosen null maka lewati
            if ($dosen->nip !== null) {
                // Ambil NIP dari setiap entri
                $nip = $dosen->nip;

                // jika nip dosen sudah ada pada tabel rapor maka lewati
                $rapor = Rapor::where('periode_rapor', $periodeakademik)
                    ->where('dosen_nip', $nip)
                    ->where('programstudi', $programstudi)
                    ->first();

                if (!$rapor) {
                    $rapor = new Rapor();
                    $rapor->periode_rapor = $periodeakademik;
                    $rapor->dosen_nip = $nip;
                    $rapor->programstudi = $programstudi;
                    $rapor->save();
                    $dataRapor[] = $rapor;
                }
            }
        }

        return response()->json($dataRapor);
    }

    // fungsi mengambil semua data rapor
    function getAllDataRapor(Request $request)
    {
        // Menentukan jumlah data per halaman
        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // Mengambil data sesuai dengan request
        $dataRapor = Rapor::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $query->where('dosen_nip', 'ilike', "%$search%")
                    ->orWhereHas('dosen', function ($query) use ($search) {
                        $query->where('nama', 'ilike', "%$search%");
                    });
            });
        })->when($request->has('perioderapor'), function ($query) use ($request) {
            $perioderapor = $request->get('perioderapor');
            $query->where('periode_rapor', $perioderapor);
        })->when($request->has('programstudi'), function ($query) use ($request) {
            $programstudi = $request->get('programstudi');
            $query->where('programstudi', $programstudi);
        })->with('dosen')
            ->paginate($perPage); // Menggunakan paginate untuk pagination

        return response()->json($dataRapor);
    }
}
