<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\UnitKerja;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Exports\PerwalianExport;

class MasterLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
        $periode = Periode::orderBy('kode_periode', 'desc')->take(50)->get();

        return view('master.laporan.index', [
            'daftar_periode' => $periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    function printLaporan(Request $request)
    {
        try {
            $periodemasuk = $request->perwalian_periode_id;
            $periodeakhir = '20242';

            $daftarPeriode = $this->generatePeriodeList($periodemasuk, $periodeakhir);

            // $nama_laporan = $request->nama_laporan;

            // dapatkan data mahasiswa with perwalian where statusmahasiswa != Lulus dan periodemasuk sesuai dengan request
            $mahasiswa = Mahasiswa::with(
                [
                    'perwalian' => function ($query) use ($daftarPeriode) {
                        $query->whereIn('id_periode', $daftarPeriode);
                },
                    'invoice' => function ($query) use ($daftarPeriode) {
                        $query->whereIn('id_periode', $daftarPeriode)
                         ->where('id_jenis_akun', 'DPP');;
                }
                ])
                ->where('statusmahasiswa', '!=', 'Lulus')
                ->where('periodemasuk', $periodemasuk)
                ->whereIn('programstudi', [
                    'Teknik Industri',
                    'Teknologi Pangan',
                    'Teknik Mesin',
                    'Teknik Informatika',
                    'Teknik Lingkungan',
                    'Perencanaan Wilayah dan Kota'
                ])
                ->orderBy('nim', 'asc')
                ->get();

            $hasil = $mahasiswa->map(function ($mhs) {
                return [
                    'nrp' => $mhs->nim,
                    'nama' => $mhs->nama,
                    'program_studi' => $mhs->programstudi,
                    'status_mahasiswa' => $mhs->statusmahasiswa,
                    'perwalian' => collect($mhs->perwalian)
                        ->sortBy('id_periode')
                        ->values()
                        ->map(function ($p) {
                            return [
                                'id_periode' => $p->id_periode,
                                'id_status_mahasiswa' => $p->id_status_mahasiswa,
                                'status_mahasiswa' => $p->status_mahasiswa,
                                'sks_lulus' => $p->sks_lulus,
                            ];
                        }),
                    'invoice' => collect($mhs->invoice)
                        ->sortBy('id_periode')
                        ->values()
                        ->map(function ($inv) {
                            return [
                                'id_periode' => $inv->id_periode,
                                'id_jenis_akun' => $inv->id_jenis_akun,
                                'uraian' => $inv->uraian,
                                'nominal_tagihan' => $inv->nominal_tagihan,
                                'nominal_terbayar' => $inv->nominal_terbayar,
                                'nominal_sisa_tagihan' => $inv->nominal_sisa_tagihan,
                                'is_lunas' => $inv->is_lunas,
                            ];
                        }),
                ];
            });

            return Excel::download(new PerwalianExport($mahasiswa, $daftarPeriode), 'laporan_perwalian.xlsx');

            // return response()->json($hasil, 200, [], JSON_PRETTY_PRINT);
      
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generatePeriodeList($start, $end)
    {
        $startYear = (int) substr($start, 0, 4);
        $startSem = (int) substr($start, 4, 1);
        $endYear = (int) substr($end, 0, 4);
        $endSem = (int) substr($end, 4, 1);

        $periodeList = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            foreach ([1, 2] as $sem) {
                if ($year === $startYear && $sem < $startSem) continue;
                if ($year === $endYear && $sem > $endSem) continue;
                $periodeList[] = $year . $sem;
            }
        }

        return $periodeList;
    }
}

  //     $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        //     $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
        //         ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
        //             $query->where('remedial_periode_id', $request->remedial_periode_id)
        //                 ->whereIn('programstudi', $unitKerjaNames);
        //         });

        //     // Menangani laporan ajuan
        //     if ($request->nama_laporan == 'ajuan') {
        //         $remedialAjuanDetail = $remedialAjuanDetail->orderBy('idmk', 'asc')
        //             ->orderBy('namakelas', 'asc')
        //             ->get(); // Memastikan pemanggilan get() sebelum diekspor
        //         return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
        //     }

        //     // Menangani laporan pembayaran
        //     if ($request->nama_laporan == 'pembayaran') {
        //         return $this->printLaporanPembayaran($request);
        //         // $remedialAjuanDetail = $remedialAjuanDetail->where('remedialajuan.status_pembayaran', 'Lunas')
        //         // return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');

        //     }