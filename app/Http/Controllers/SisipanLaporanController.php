<?php

namespace App\Http\Controllers;

use App\Exports\SisipanAjuanExport;
use App\Exports\SisipanPembayaranExport;
use App\Models\SisipanPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\SisipanAjuan;
use App\Models\SisipanAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class SisipanLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $daftar_periode = SisipanPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('sisipan.laporan.index', [
            'daftar_periode' => $daftar_periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    // print-laporan
    // function printLaporan(Request $request)
    // {
    //     $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

    //     $sisipanAjuanDetail = SisipanAjuanDetail::with(['krs', 'sisipanajuan', 'sisipanajuan.sisipanperiode', 'sisipanajuan.mahasiswa', 'sisipanajuan.userverifikasi'])
    //         ->whereHas('sisipanajuan', function ($query) use ($request, $unitKerjaNames) {
    //             $query->where('sisipan_periode_id', $request->sisipan_periode_id)
    //                 ->whereIn('programstudi', $unitKerjaNames);
    //         });


    //     // return response()->json($sisipanAjuanDetail);

    //     if ($request->nama_laporan == 'ajuan') {
    //         $sisipanAjuanDetail = $sisipanAjuanDetail->orderBy('idmk', 'asc')
    //             ->orderBy('namakelas', 'asc')
    //             ->get();
    //         return Excel::download(new SisipanAjuanExport($sisipanAjuanDetail), 'sisipan-ajuan.xlsx');
    //     }

    //     if ($request->nama_laporan == 'pembayaran') {
    //         $sisipanAjuanDetail->where('sisipanajuan.status_pembayaran', 'Lunas')
    //             ->get();
    //         return Excel::download(new SisipanPembayaranExport($sisipanAjuanDetail), 'sisipan-pembayaran.xlsx');
    //     }

    //     // return Excel::download(new SisipanAjuanExport($sisipanAjuanDetail), 'sisipan-ajuan.xlsx');
    // }

    function printLaporan(Request $request)
    {
        try {
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

            $sisipanAjuanDetail = SisipanAjuanDetail::with(['krs', 'sisipanajuan', 'sisipanajuan.sisipanperiode', 'sisipanajuan.mahasiswa', 'sisipanajuan.userverifikasi'])
                ->whereHas('sisipanajuan', function ($query) use ($request, $unitKerjaNames) {
                    $query->where('sisipan_periode_id', $request->sisipan_periode_id)
                        ->whereIn('programstudi', $unitKerjaNames);
                });

            // Menangani laporan ajuan
            if ($request->nama_laporan == 'ajuan') {
                $sisipanAjuanDetail = $sisipanAjuanDetail->orderBy('idmk', 'asc')
                    ->orderBy('namakelas', 'asc')
                    ->get(); // Memastikan pemanggilan get() sebelum diekspor
                return Excel::download(new SisipanAjuanExport($sisipanAjuanDetail), 'sisipan-ajuan.xlsx');
            }

            // Menangani laporan pembayaran
            if ($request->nama_laporan == 'pembayaran') {
                return $this->printLaporanPembayaran($request);
                // $sisipanAjuanDetail = $sisipanAjuanDetail->where('sisipanajuan.status_pembayaran', 'Lunas')
                // return Excel::download(new SisipanPembayaranExport($sisipanAjuanDetail), 'sisipan-pembayaran.xlsx');

            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    function printLaporanPembayaran(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $sisipanAjuanDetail = SisipanAjuanDetail::with([
            'krs',
            'sisipanajuan' => function ($query) {
                $query->select('id', 'sisipan_periode_id', 'nim', 'programstudi', 'va', 'total_bayar', 'jumlah_bayar', 'status_pembayaran', 'bukti_pembayaran', 'tgl_pembayaran', 'tgl_pengajuan', 'is_lunas', 'verified_by');
            },
            'sisipanajuan.sisipanperiode' => function ($query) {
                $query->select('id', 'nama_periode');
            },
            'sisipanajuan.mahasiswa' => function ($query) {
                $query->select('id', 'nama');
            },
            'sisipanajuan.userverifikasi' => function ($query) {
                $query->select('id', 'name');
            }
        ])->whereHas('sisipanajuan', function ($query) use ($request, $unitKerjaNames) {
            $query->where('sisipan_periode_id', $request->sisipan_periode_id)
                ->whereIn('programstudi', $unitKerjaNames);
        })
            ->join('sisipan_ajuan', 'sisipan_ajuan_detail.sisipan_ajuan_id', '=', 'sisipan_ajuan.id')
            ->orderBy('sisipan_ajuan.nim', 'asc')
            ->select('sisipan_ajuan_detail.*') // Pastikan hanya kolom yang diperlukan diambil
            ->get();

        return Excel::download(new SisipanPembayaranExport($sisipanAjuanDetail), 'sisipan-pembayaran.xlsx');
    }
}
