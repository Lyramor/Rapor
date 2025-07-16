<?php

namespace App\Http\Controllers;

use App\Exports\RemedialAjuanExport;
use App\Exports\RemedialPembayaranExport;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class RemedialLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $daftar_periode = RemedialPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('remedial.laporan.index', [
            'daftar_periode' => $daftar_periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    // print-laporan
    // function printLaporan(Request $request)
    // {
    //     $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

    //     $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
    //         ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
    //             $query->where('remedial_periode_id', $request->remedial_periode_id)
    //                 ->whereIn('programstudi', $unitKerjaNames);
    //         });


    //     // return response()->json($remedialAjuanDetail);

    //     if ($request->nama_laporan == 'ajuan') {
    //         $remedialAjuanDetail = $remedialAjuanDetail->orderBy('idmk', 'asc')
    //             ->orderBy('namakelas', 'asc')
    //             ->get();
    //         return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    //     }

    //     if ($request->nama_laporan == 'pembayaran') {
    //         $remedialAjuanDetail->where('remedialajuan.status_pembayaran', 'Lunas')
    //             ->get();
    //         return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');
    //     }

    //     // return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    // }

    function printLaporan(Request $request)
    {
        try {
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

            $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
                ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id)
                        ->whereIn('programstudi', $unitKerjaNames);
                });

            // Menangani laporan ajuan
            if ($request->nama_laporan == 'ajuan') {
                $remedialAjuanDetail = $remedialAjuanDetail->orderBy('idmk', 'asc')
                    ->orderBy('namakelas', 'asc')
                    ->get(); // Memastikan pemanggilan get() sebelum diekspor
                return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
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


    function printLaporanPembayaran(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $remedialAjuanDetail = RemedialAjuanDetail::with([
            'krs',
            'remedialajuan' => function ($query) {
                $query->select('id', 'remedial_periode_id', 'nim', 'programstudi', 'va', 'total_bayar', 'jumlah_bayar', 'status_pembayaran', 'bukti_pembayaran', 'tgl_pembayaran', 'tgl_pengajuan', 'is_lunas', 'verified_by');
            },
            'remedialajuan.remedialperiode' => function ($query) {
                $query->select('id', 'nama_periode');
            },
            'remedialajuan.mahasiswa' => function ($query) {
                $query->select('id', 'nama');
            },
            'remedialajuan.userverifikasi' => function ($query) {
                $query->select('id', 'name');
            }
        ])->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
            $query->where('remedial_periode_id', $request->remedial_periode_id)
                ->whereIn('programstudi', $unitKerjaNames);
        })
            ->join('remedial_ajuan', 'remedial_ajuan_detail.remedial_ajuan_id', '=', 'remedial_ajuan.id')
            ->orderBy('remedial_ajuan.nim', 'asc')
            ->select('remedial_ajuan_detail.*') // Pastikan hanya kolom yang diperlukan diambil
            ->get();

        return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');
    }
}
