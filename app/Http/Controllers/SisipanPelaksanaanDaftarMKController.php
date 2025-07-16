<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\KelasKuliah;
use App\Models\Krs;
use App\Models\SisipanPeriode;
use App\Models\SisipanAjuan;
use App\Models\ProgramStudi;
use App\Models\SisipanAjuanDetail;
use App\Models\SisipanKelas;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;


class SisipanPelaksanaanDaftarMKController extends Controller
{
    public function daftarMatakuliah(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    ->where('unit_kerja_id', $unitKerja->id)
                    ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = SisipanPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')->take(10)->get();


            $query = SisipanAjuanDetail::with('matakuliah')
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
                'sisipan.pelaksanaan.daftar-mk.index',
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

            $matakuliah = SisipanAjuanDetail::with('matakuliah', 'sisipanajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->first();

            // return response()->json($request->all());
            $ajuandetail = SisipanAjuanDetail::with(['matakuliah', 'sisipanajuan', 'krs', 'kelasKuliah'])
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
                'sisipan.pelaksanaan.daftar-mk.detail.peserta',
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
            //sisipanajuandetail get
            $sisipanajuandetail = SisipanAjuanDetail::where('idmk', $request->editIdMK)
                ->where('kode_periode', $request->editKodePeriode)
                ->where('namakelas', $request->editKelas)
                ->get();

            // update nip sisipanajuandetail
            $sisipanajuandetail->each(function ($detail) use ($pegawai) {
                $detail->nip = $pegawai->nip;
                $detail->save();
            });

            SisipanAjuanDetail::where('idmk', $request->editIdMK)
                ->where('kode_periode', $request->editKodePeriode)
                ->where('namakelas', $request->editKelas)
                ->update([
                    'nip' => $pegawai->nip,
                ]);

            //get kelasKuliah update
            $kelas = KelasKuliah::where('kodemk', $request->editIdMK)
                ->where('periodeakademik', $sisipanajuandetail[0]->krs->idperiode)
                ->where('namakelas', $request->editKelas)
                ->get();


            KelasKuliah::where('kodemk', $request->editIdMK)
                ->where('periodeakademik', $sisipanajuandetail[0]->krs->idperiode)
                ->where('namakelas', $request->editKelas)
                ->update([
                    'nip' => $pegawai->nip,
                    'namadosen' => $pegawai->nama,
                ]);

            // return response()->json([
            //     'request' => $request->all(),
            //     'sisipanajuandetail' => $sisipanajuandetail,
            //     'kelas' => $kelas,
            // ]);

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
                'sisipan_periode_id' => 'required',
            ]);

            SisipanAjuanDetail::where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima');
                })
                ->update([
                    'status_ajuan' => 'Dibatalkan',
                ]);

            // delete Sisipan Kelas and sisipan kelas peserta
            $data = SisipanKelas::where('sisipan_periode_id', $request->sisipan_periode_id)
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
            $matakuliah = SisipanAjuanDetail::with('matakuliah', 'sisipanajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->first();

            // return response()->json($request->all());
            $kelas = SisipanKelas::with(['matakuliah', 'sisipanperiode', 'peserta'])
                ->where('sisipan_periode_id', $request->sisipan_periode_id)
                ->where('kodemk', $request->idmk)
                ->get();

            // return response()->json($kelas);

            return view(
                'sisipan.pelaksanaan.daftar-mk.detail.kelas',
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
