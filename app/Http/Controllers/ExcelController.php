<?php

namespace App\Http\Controllers;

use App\Exports\RaporExport;
use App\Models\Rapor;
use Illuminate\Http\Request;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PertanyaanExport;
use App\Exports\KuesionerSDMExport;
use App\Exports\DaftarMahasiswaNonAktif;
use App\Exports\RekeningKoranExport;
use App\Exports\RekomendasiJumlahKelas;
use App\Models\KelasKuliah;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;


class ExcelController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new TemplateExport, 'template_dokumen.xlsx');
    }

    public function RaporTemplate(Request $request)
    {
        // Mendapatkan parameter periode dan program_studi dari request
        $periode = $request->input('periode');
        $programStudi = $request->input('program_studi');

        // Jika periode dan program_studi tidak ada, maka download template rapor tanpa data
        if (!$periode && !$programStudi) {
            return Excel::download(new RaporExport, 'template_rapor.xlsx');
        }

        $datarapor = Rapor::with('dosen')
            ->where('periode_rapor', $periode)
            ->where('programstudi', $programStudi)
            ->get();

        // return data rapor json
        // return response()->json($datarapor);

        // Jika periode dan program_studi ada, maka download template rapor dengan data
        return Excel::download(new RaporExport($datarapor), 'template_rapor.xlsx');
    }

    //templateuploadpertanyaan
    public function uploadTemplatePertanyaan()
    {
        return Excel::download(new PertanyaanExport, 'template_pertanyaan.xlsx');
    }

    public function downloadTemplateKuesionerSDM()
    {
        return Excel::download(new KuesionerSDMExport, 'template-upload-kuesionersdm.xlsx');
    }

    public function downloadMhsNonAktif(Request $request)
    {
        // return "Hello";
        // Mendapatkan parameter periode dan program_studi dari request
        // $periode = $request->input('periode');
        // $programStudi = $request->input('program_studi');

        // echo "Hallo ini downloadMhsNonAktif";

        // $mahasiswa = Mahasiswa::with(['akm' => function ($query) {
        //     $query->where('statusmhs', 'A')
        //         ->orWhere('statusmhs', 'KM')
        //         ->orderBy('idperiode', 'desc');
        // }])
        $mahasiswa = Mahasiswa::with(['akm'])
            ->where(function ($query) {
                $query->where('programstudi', 'Teknik Informatika')
                    ->orWhere('programstudi', 'Teknik Lingkungan')
                    ->orWhere('programstudi', 'Teknik Mesin')
                    ->orWhere('programstudi', 'Teknologi Pangan')
                    ->orWhere('programstudi', 'Teknik Industri')
                    ->orWhere('programstudi', 'Perencanaan Wilayah dan Kota');
            })
            ->where(function ($query) {
                $query->where('periodemasuk', '20171')
                    ->orWhere('periodemasuk', '20161')
                    ->orWhere('periodemasuk', '20151')
                    ->orWhere('periodemasuk', '20141')
                    ->orWhere('periodemasuk', '20131')
                    ->orWhere('periodemasuk', '20121')
                    ->orWhere('periodemasuk', '20111')
                    ->orWhere('periodemasuk', '20101')
                    ->orWhere('periodemasuk', '20091')
                    ->orWhere('periodemasuk', '20081');
            })
            // ->where('periodemasuk', '20202')
            ->get();
        // return response()->json($mahasiswa);
        // Jika periode dan program_studi tidak ada, maka download template rapor tanpa data
        // if (!$periode && !$programStudi) {
        //     return Excel::download(new RaporExport, 'template_rapor.xlsx');
        // }

        // $datarapor = Rapor::with('dosen')
        //     ->where('periode_rapor', $periode)
        //     ->where('programstudi', $programStudi)
        //     ->get();

        // return data rapor json
        // return response()->json($datarapor);

        // Jika periode dan program_studi ada, maka download template rapor dengan data
        return Excel::download(new DaftarMahasiswaNonAktif($mahasiswa), 'daftar mahasiswa non-aktif.xlsx');


        // return Excel::download(new DaftarMahasiswaNonAktif, 'daftar-mhs-non-aktif.xlsx');
    }

    public function downloadRekomendasiKelas(Request $request)
    {
        $kelasKuliah = KelasKuliah::with('jadwalPerkuliahan')
            ->where('periodeakademik', '20231')
            ->where(function ($query) {
                $query->where('programstudi', 'Teknik Informatika')
                    ->orWhere('programstudi', 'Teknik Lingkungan')
                    ->orWhere('programstudi', 'Teknik Mesin')
                    ->orWhere('programstudi', 'Teknologi Pangan')
                    ->orWhere('programstudi', 'Teknik Industri')
                    ->orWhere('programstudi', 'Perencanaan Wilayah dan Kota');
            })
            ->where('sistemkuliah', 'Reguler')
            // where namakelas not like '%LAB%'
            ->where('namakelas', 'not like', 'K')

            // ->select('periodeakademik', 'programstudi', 'kurikulum', 'kodemk', 'namamk', 'sistemkuliah')
            // ->groupBy('periodeakademik', 'programstudi', 'kurikulum', 'kodemk', 'namamk', 'sistemkuliah')
            ->get();

        // return response()->json($kelasKuliah);

        return Excel::download(new RekomendasiJumlahKelas($kelasKuliah), 'daftar-rekomendasi-jumlah-kelas.xlsx');
    }

    public function downloadTemplateRekor()
    {
        return Excel::download(new RekeningKoranExport(), 'template_rekening_koran.xlsx');
    }
}
