<?php

namespace App\Http\Controllers;

use App\Exports\RemedialAjuanExport;
use App\Exports\RemedialPembayaranExport;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\KuesionerSDM;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Models\Periode;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ChartHelper;
use Spatie\Browsershot\Browsershot;

class KuesionerLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(50)->get();

        return view('kuesioner.laporan.index', [
            'daftar_periode' => $periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    function printLaporan(Request $request)
    {
        // dd($request->all());
        try {
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

            $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
                ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id)
                        ->whereIn('programstudi', $unitKerjaNames);
                });

            // Menangani laporan ajuan
            if ($request->nama_laporan == 'kuesioner') {
                return $this->printRekapKuesioner($request);
            }

            // Menangani laporan pembayaran
            if ($request->nama_laporan == 'pembayaran') {
                return $this->printLaporanPembayaran($request);
                // $remedialAjuanDetail = $remedialAjuanDetail->where('remedialajuan.status_pembayaran', 'Lunas')
                // return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');

            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }

    // printRekapKuesioner
    function printRekapKuesioner(Request $request)
    {
        // $kuesioners = KuesionerSDM::with(['periode', 'pegawai.unitKerja'])
        //     ->where('kode_periode', $request->kuesioner_periode_id)
        //     ->whereHas('pegawai', function ($query) use ($request) {
        //         $query->where('unit_kerja_id', $request->programstudi);
        //     })
        //     ->get();

        // $dataRekap = [];

        // foreach ($kuesioners as $kuesioner) {
        //     $penilaian = Penilaian::selectRaw('kuesioner_sdm_id, unsur_penilaian_id, AVG(jawaban_numerik) as rata_rata')
        //         ->where('kuesioner_sdm_id', $kuesioner->id)
        //         ->groupBy('kuesioner_sdm_id', 'unsur_penilaian_id')
        //         ->get();

        //     $dataRekap[] = [
        //         'kuesioner' => $kuesioner,
        //         'penilaian' => $penilaian,
        //     ];
        // }

        // return response()->json($dataRekap, 200, [], JSON_PRETTY_PRINT);

        $periodeId = $request->input('kuesioner_periode_id');
        $unitKerjaId = $request->input('programstudi');

        $kuesionerList = KuesionerSDM::with(['pegawai.unitKerja', 'periode', 'soalKuisionerSDM.unsurPenilaian'])
            ->where('kode_periode', $periodeId)
            ->whereHas('pegawai', function ($query) use ($unitKerjaId) {
                $query->where('unit_kerja_id', $unitKerjaId);
            })
            ->get();

        $penilaian = Penilaian::whereIn('kuesioner_sdm_id', $kuesionerList->pluck('id')->toArray())
            ->get();

        
        $grouped = collect();

        foreach ($kuesionerList as $kuesioner) {
            $nip = $kuesioner->pegawai->nip;
            $periode = $kuesioner->kode_periode;
            $key = $nip . '-' . $periode;

            if (!$grouped->has($key)) {
                $grouped->put($key, [
                    'nip' => $nip,
                    'nama' => $kuesioner->pegawai->nama,
                    'periode' => $periode,
                    'unit' => $kuesioner->pegawai->unitKerja->nama_unit ?? '-',
                    'unsur' => []
                ]);
            }

            foreach ($kuesioner->soalKuisionerSDM as $soal) {
                $unsurId = $soal->unsur_penilaian_id;
                $unsurNama = $soal->unsurPenilaian->nama;

                $nilai = $penilaian->firstWhere(fn ($p) => $p->kuesioner_sdm_id === $kuesioner->id && $p->unsur_penilaian_id === $unsurId);

                $temp = $grouped->get($key);

                if (!isset($temp['unsur'][$unsurId])) {
                    $temp['unsur'][$unsurId] = [
                        'nama' => $unsurNama,
                        'total' => 0,
                        'count' => 0,
                        'rata_rata' => 0
                    ];
                }

                if ($nilai) {
                    $temp['unsur'][$unsurId]['total'] += $nilai->jawaban_numerik;
                    $temp['unsur'][$unsurId]['count'] += 1;
                }

                $grouped->put($key, $temp);
            }
        }

        foreach ($grouped as $key => $data) {
            foreach ($data['unsur'] as $id => $unsur) {
                $count = max($unsur['count'], 1);
                $data['unsur'][$id]['rata_rata'] = round($unsur['total'] / $count, 2);
            }

            // Generate radar chart as base64 image
            // $labels = collect($data['unsur'])->pluck('nama')->toArray();
            // $values = collect($data['unsur'])->pluck('rata_rata')->toArray();
            
            // dd($labels, $values);
            // $data['chart'] = ChartHelper::generateRadarChartBase64($labels, $values);

            
            $grouped->put($key, $data);
        }

        $grouped = $grouped->values();

        $pdf = PDF::loadView('pdf.kuesioner-dp3', [
                'result' => $grouped,
            ]);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-kuesioner-sdm.pdf');
        
        // return response()->json($grouped, 200, [], JSON_PRETTY_PRINT);
    }

}
