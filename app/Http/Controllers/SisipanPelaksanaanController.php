<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\SisipanPeriode;
use App\Models\SisipanAjuan;
use App\Models\ProgramStudi;
use App\Models\SisipanAjuanDetail;
use Illuminate\Support\Facades\DB;

class SisipanPelaksanaanController extends Controller
{
    // index
    public function daftarMatakuliah(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = $this->daftarPeriode($unitKerja);

            // return response()->json($daftar_periode);

            $query = SisipanAjuanDetail::with('kelasKuliah')
                ->whereHas('kelasKuliah', function ($query) use ($unitKerjaNames) {
                    $query->whereIn('programstudi', $unitKerjaNames);
                })
                ->where('kode_periode', $periodeTerpilih->kode_periode);


            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->whereHas('kelasKuliah', function ($query) use ($programstudis) {
                        $query->where('programstudi', $programstudis->nama_unit);
                    });

                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search')) {
                if ($request->get('search') != null && $request->get('search') != '') {
                    $query->whereHas('kelasKuliah', function ($query) use ($request) {
                        $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                            ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                    });
                }
            }

            $ajuandetail = $query->select('kode_periode', 'idmk', DB::raw('COUNT(idmk) as total_peserta'))
                ->groupBy('kode_periode', 'idmk')
                ->paginate($request->get('perPage', 10));

            // return response()->json($ajuandetail);
            $total = $ajuandetail->total();

            return view(
                'sisipan.pelaksanaan.daftar-mk',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'unitkerja' => $unitKerja,
                    'data' => $ajuandetail,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // daftarPeriode
    public function daftarPeriode($unitKerja)
    {
        $daftar_periode = SisipanPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_id)
            ->get();
        return $daftar_periode;
    }
}
