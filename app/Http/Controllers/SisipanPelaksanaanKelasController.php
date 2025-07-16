<?php

namespace App\Http\Controllers;

use App\Exports\DataKelasExport;
use App\Models\SisipanAjuan;
use App\Models\SisipanAjuanDetail;
use App\Models\SisipanKelas;
use Illuminate\Http\Request;
use App\Models\SisipanKelasPeserta;
use App\Models\SisipanPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SisipanPelaksanaanKelasController extends Controller
{
    public function daftarKelas(Request $request)
    {
        try {
            if ($request->has('action') && $request->action === 'download') {
                return $this->downloadDataKelas($request);
            }

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

            $query = SisipanKelas::with(['sisipanperiode', 'kelaskuliah', 'dosen'])
                ->where('sisipan_periode_id', $periodeTerpilih->id)
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

            if ($request->filled('search')) {
                $query->whereHas('kelaskuliah', function ($query) use ($request) {
                    $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                });
            }

            $daftarkelas = $query->paginate($request->get('perPage', 10));

            $total = $daftarkelas->total();

            return view(
                'sisipan.pelaksanaan.kelas.index',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'unitkerja' => $unitKerja,
                    'data' => $daftarkelas,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // detailKelas
    public function detailKelas($id)
    {
        try {
            $kelas = SisipanKelas::with(['sisipanperiode', 'kelaskuliah', 'dosen', 'matakuliah', 'peserta'])
                ->where('id', $id)
                ->first();

            $peserta = SisipanKelasPeserta::with('mahasiswa')
                ->where('sisipan_kelas_id', $id)
                ->get();

            $total = $peserta->count();

            return view(
                'sisipan.pelaksanaan.kelas.detail.kelas',
                [
                    'kelas' => $kelas,
                    'data' => $peserta,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    public function tambahPerMKAjax(Request $request)
    {
        $request->validate([
            'sisipan_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {
            $mk = SisipanAjuanDetail::with('SisipanAjuan')
                ->whereHas('SisipanAjuan', function ($query) use ($request) {
                    $query->where('sisipan_periode_id', $request->sisipan_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->get();

            $grouped = $mk->groupBy(function ($item) {
                return $item->kode_periode . '-' . $item->idmk;
            });

            $data = $grouped->map(function ($items, $key) {
                $firstItem = $items->first();
                return [
                    'kode_periode' => $firstItem->kode_periode,
                    'idmk' => $firstItem->idmk,
                    'nip' => $firstItem->nip,
                    'detail' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'sisipan_ajuan_id' => $item->sisipan_ajuan_id,
                            'programstudi' => $item->SisipanAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->SisipanAjuan->nim, // Assuming you have a 'nim' field in SisipanAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_sisipan' => $item->harga_sisipan,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = SisipanKelas::create([
                    'sisipan_periode_id' => $request->sisipan_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    SisipanKelasPeserta::create([
                        'sisipan_kelas_id' => $kelas->id,
                        'nim' => $detail['nim'],
                        'nnumerik' => 0,
                        'nhuruf' => '',
                    ]);
                }

                // $daftarKelas[] = $kelas;
            }

            // update status ajuan mk diterima
            $mk->each(function ($item) {
                $item->update([
                    'status_ajuan' => 'Diterima',
                ]);
            });


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }

    // tambahPerDosenAjax
    public function tambahPerDosenAjax(Request $request)
    {
        $request->validate([
            'sisipan_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {

            $mk = SisipanAjuanDetail::with('SisipanAjuan')
                ->whereHas('SisipanAjuan', function ($query) use ($request) {
                    $query->where('sisipan_periode_id', $request->sisipan_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->get();

            $grouped = $mk->groupBy(function ($item) {
                return $item->kode_periode . '-' . $item->idmk . '-' . $item->nip;
            });

            $data = $grouped->map(function ($items, $key) {
                $firstItem = $items->first();
                return [
                    'kode_periode' => $firstItem->kode_periode,
                    'idmk' => $firstItem->idmk,
                    'nip' => $firstItem->nip,
                    'detail' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'sisipan_ajuan_id' => $item->sisipan_ajuan_id,
                            'programstudi' => $item->SisipanAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->SisipanAjuan->nim, // Assuming you have a 'nim' field in SisipanAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_sisipan' => $item->harga_sisipan,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = SisipanKelas::create([
                    'sisipan_periode_id' => $request->sisipan_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    SisipanKelasPeserta::create([
                        'sisipan_kelas_id' => $kelas->id,
                        'nim' => $detail['nim'],
                        'nnumerik' => 0,
                        'nhuruf' => '',
                    ]);
                }

                // $daftarKelas[] = $kelas;
            }

            // update status ajuan mk diterima
            $mk->each(function ($item) {
                $item->update([
                    'status_ajuan' => 'Diterima',
                ]);
            });


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }

    // download data kelas excell
    public function downloadDataKelas(Request $request)
    {
        try {
            $request->validate([
                'periodeTerpilih' => 'required',
                'programstudi' => 'required',
            ]);

            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesId($request->programstudi);

            $query = SisipanKelas::with(['sisipanperiode', 'kelaskuliah', 'dosen'])
                ->where('sisipan_periode_id', $request->periodeTerpilih)
                ->whereIn('programstudi', $unitKerjaNames);

            $daftarkelas = $query->get();

            return Excel::download(new DataKelasExport($daftarkelas), 'data_kelas.xlsx');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    public function uploadDataKelas(Request $request)
    {
        try {
            $request->validate([
                'sisipan_periode_id' => 'required|exists:sisipan_periode,id',
                'file' => 'required|mimes:xls,xlsx'
            ]);

            $file = $request->file('file');
            $data = Excel::toArray([], $file);

            $sukses = 0;
            $gagal = 0;

            array_shift($data[0]);

            foreach ($data[0] as $row) {
                // Jika kolom A kosong maka lewati
                if (empty($row[1]) || $row[1] == '' || $row[1] == null) {
                    break;
                } else {

                    $sisipanKelas = SisipanKelas::where('kodemk', 'ilike', '%' . $row[4] . '%')
                        ->where('nip', 'ilike', '%' . $row[6] . '%')
                        ->where('sisipan_periode_id', $request->sisipan_periode_id)
                        ->first();

                    if ($sisipanKelas) {
                        $kodeedlink = $row[9] ?? '';

                        $sisipanKelas->update([
                            'kode_edlink' => $kodeedlink,
                            'catatan' => $row[10],
                        ]);
                        $sukses++;
                    } else {
                        $gagal++;
                    }
                }
            }

            return back()->with('message', $sukses . ' data berhasil dieksekusi, ' . $gagal . ' data gagal dieksekusi');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // printPresensi
    public function printPresensi($id)
    {
        try {
            $kelas = SisipanKelas::with(['sisipanperiode', 'kelaskuliah', 'dosen', 'matakuliah', 'peserta'])
                ->where('id', $id)
                ->first();

            // return response()->json($kelas);

            $peserta = DB::table('sisipan_kelas_peserta')
                ->select('sisipan_kelas_peserta.id', 'mhs.nim as mhs_nim', 'mhs.nama as mhs_nama', 'rp.kode_periode as kode_periode', 'krs.nhuruf as old_nhuruf', 'krs.nnumerik as old_nnumerik')
                ->leftJoin('mahasiswa as mhs', 'sisipan_kelas_peserta.nim', '=', 'mhs.nim')
                ->leftJoin('sisipan_kelas as rk', 'sisipan_kelas_peserta.sisipan_kelas_id', '=', 'rk.id')
                ->leftJoin('sisipan_periode as rp', 'rk.sisipan_periode_id', '=', 'rp.id')
                ->leftJoin('krs', function ($join) {
                    $join->on('sisipan_kelas_peserta.nim', '=', 'krs.nim')
                        ->whereColumn('rk.kodemk', 'krs.idmk')
                        ->whereColumn('rp.kode_periode', 'krs.idperiode');
                })
                ->where('sisipan_kelas_id', $id)
                ->groupBy('sisipan_kelas_peserta.id', 'mhs.nim', 'mhs.nama', 'rp.kode_periode', 'krs.nhuruf', 'krs.nnumerik')
                ->orderBy('mhs.nim')
                ->get();

            $peserta = $peserta->unique('id');

            // return response()->json($peserta);

            $total = $peserta->count();

            $pdf = PDF::loadView('pdf.presensi-kelas', [
                'kelas' => $kelas,
                'data' => $peserta,
                'total' => $total,
            ]);
            $pdf->setPaper('A4', 'potrait');

            return $pdf->download($id . '.pdf');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
