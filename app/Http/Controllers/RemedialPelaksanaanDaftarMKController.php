<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\KelasKuliah;
use App\Models\Krs;
use App\Models\RemedialPeriode;
use App\Models\RemedialAjuan;
use App\Models\ProgramStudi;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialKelas;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;


class RemedialPelaksanaanDaftarMKController extends Controller
{
    public function daftarMatakuliah(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->where('unit_kerja_id', $unitKerja->id)
                    ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = RemedialPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')->take(10)->get();


            $query = RemedialAjuanDetail::with('matakuliah')
                ->where('kode_periode', $periodeTerpilih->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->whereHas('matakuliah', function ($query) use ($unitKerjaNames) {
                    $query->whereIn('programstudi', $unitKerjaNames);
                });

            if ($request->filled('programstudi')) {

                $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                if (!$programstudis) {
                    return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                }

                $query->whereHas('matakuliah', function ($query) use ($programstudis, $unitKerjaNames) {
                    if ($programstudis->jenis_unit == 'Program Studi') {
                        $query->where('programstudi', $programstudis->nama_unit);
                    } else {
                        $query->whereIn('programstudi', $unitKerjaNames);
                    }
                });

                $programstuditerpilih = $programstudis;
            }

            if ($request->has('search')) {
                if ($request->get('search') != null && $request->get('search') != '') {
                    $query->whereHas('matakuliah', function ($query) use ($request) {
                        $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                            ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                    });
                }
            }

            if ($request->filled('status_ajuan') && $request->status_ajuan != 'all') {
                $query->where('status_ajuan', $request->status_ajuan);
            }

            $ajuandetail = $query->select('kode_periode', 'idmk', 'status_ajuan', DB::raw('COUNT(idmk) as total_peserta'))
                ->groupBy('kode_periode', 'idmk', 'status_ajuan')
                ->paginate($request->get('perPage', 10));

            $total = $ajuandetail->total();

            return view(
                'remedial.pelaksanaan.daftar-mk.index',
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

    // detail
    public function pesertaMatakuliah(Request $request)
    {
        try {

            $matakuliah = RemedialAjuanDetail::with('matakuliah', 'remedialajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->first();

            // return response()->json($request->all());
            $ajuandetail = RemedialAjuanDetail::with(['matakuliah', 'remedialajuan', 'krs', 'kelasKuliah'])
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->paginate($request->get('perPage', 10));

            // return response()->json($ajuandetail);

            return view(
                'remedial.pelaksanaan.daftar-mk.detail.peserta',
                [
                    'matakuliah' => $matakuliah,
                    'data' => $ajuandetail,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // editKelasAjuan
    public function editKelasAjuan(Request $request)
    {
        try {
            $request->validate([
                'editNipDosen' => 'required',
                'editKelas' => 'required',
                'editIdMK' => 'required',
                'editKodePeriode' => 'required',
            ]);

            $pegawai = Pegawai::where('nip', $request->editNipDosen)->first();
            //remedialajuandetail update
            RemedialAjuanDetail::where('idmk', $request->editIdMK)
                ->where('kode_periode', $request->editKodePeriode)
                ->where('namakelas', $request->editKelas)
                ->update([
                    'nip' => $pegawai->nip,
                ]);

            //kelasKuliah update
            KelasKuliah::where('kodemk', $request->editIdMK)
                ->where('periodeakademik', $request->editKodePeriode)
                ->where('namakelas', $request->editKelas)
                ->update([
                    'nip' => $pegawai->nip,
                    'namadosen' => $pegawai->nama,
                ]);

            return back()->with('message', 'Berhasil mengubah dosen pengampu utama');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //batalkanKelasAjuan
    public function batalkanKelasAjuan(Request $request)
    {
        try {
            $request->validate([
                'kodemk' => 'required',
                'kode_periode' => 'required',
                'remedial_periode_id' => 'required',
            ]);

            RemedialAjuanDetail::where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima');
                })
                ->update([
                    'status_ajuan' => 'Dibatalkan',
                ]);

            // delete Remedial Kelas and remedial kelas peserta
            $data = RemedialKelas::where('remedial_periode_id', $request->remedial_periode_id)
                ->where('kodemk', $request->kodemk)
                ->get();

            foreach ($data as $d) {
                $d->peserta()->delete();
                $d->delete();
            }

            return back()->with('message', 'Berhasil membatalkan kelas ajuan');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //kelasMatakuliah
    public function kelasMatakuliah(Request $request)
    {
        try {
            $matakuliah = RemedialAjuanDetail::with('matakuliah', 'remedialajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->first();

            // return response()->json($request->all());
            $kelas = RemedialKelas::with(['matakuliah', 'remedialperiode', 'peserta'])
                ->where('remedial_periode_id', $request->remedial_periode_id)
                ->where('kodemk', $request->idmk)
                ->get();

            // return response()->json($kelas);

            return view(
                'remedial.pelaksanaan.daftar-mk.detail.kelas',
                [
                    'matakuliah' => $matakuliah,
                    'data' => $kelas,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
