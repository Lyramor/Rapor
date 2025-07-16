<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\ProgramStudi;
use App\Models\Rapor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    function index()
    {
        // dapatkan 10 data paling akhir dari Periode
        $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

        // dapatkan data dari model Program Studi
        $daftar_programstudi = ProgramStudi::all();

        return view('laporan.index', [
            'daftar_periode' => $daftar_periode,
            'daftar_programstudi' => $daftar_programstudi,
        ]);
    }

    function generateLaporanKinerja(Request $request)
    {
        // Mengambil data sesuai dengan request
        $dataRapor = Rapor::when($request->has('periode_rapor'), function ($query) use ($request) {
            $periode_rapor = $request->periode_rapor;
            $query->where('periode_rapor', $periode_rapor);
        })->when($request->has('programstudi'), function ($query) use ($request) {
            $programstudi = $request->programstudi;
            $query->where('programstudi', $programstudi);
        })->when($request->has('dosen_nip'), function ($query) use ($request) {
            $dosen_nip = $request->dosen_nip;
            if ($dosen_nip != null || $dosen_nip != '') {
                $query->where('dosen_nip', $dosen_nip);
            }
        })->with(['dosen', 'periode'])
            ->get();

        $periode = Periode::where('kode_periode', $request->periode_rapor)->pluck('nama_periode')->first();
        $periode = $this->formatPeriode($periode);
        // return response()->json($dataRapor);

        // Set lokalisasi untuk Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        // Mendapatkan tanggal hari ini dengan format tanggal bulan dan tahun bahasa Indonesia
        $tanggal_sekarang = Carbon::now()->translatedFormat('d F Y');

        $data = [
            'title' => 'RAPOR KINERJA INDIVIDU',
            'subtitle' => $periode,
            'dataRapor' => $dataRapor,
            'tanggal' => $tanggal_sekarang,
        ];

        // // $pdf = Pdf::loadView('pdf.rapor',);
        $pdf = Pdf::loadView('pdf.rapor', $data);
        return $pdf->download('document.pdf');
    }

    private function formatPeriode($periode)
    {
        // Pisahkan tahun dan jenis semester
        $parts = explode(' ', $periode);
        $tahun = $parts[0];
        $semester = $parts[1];

        // Ubah jenis semester menjadi teks yang lebih bermakna
        switch ($semester) {
            case 'Ganjil':
                $semester = 'Semester Ganjil';
                break;
            case 'Genap':
                $semester = 'Semester Genap';
                break;
            default:
                $semester = '';
        }

        $nexttahun = $tahun + 1;

        // Gabungkan kembali menjadi format yang diinginkan
        $formattedPeriode = $semester . ' ' . $tahun . '/' . $nexttahun;

        return $formattedPeriode;
    }
}
