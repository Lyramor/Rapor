<?php

namespace App\Http\Controllers;

use App\Exports\DataKelasExport;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialKelas;
use Illuminate\Http\Request;
use App\Models\RemedialKelasPeserta;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekeningKoranExport;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RemedialPelaksanaanKelasController extends Controller
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

            $query = RemedialKelas::with(['remedialperiode', 'kelaskuliah', 'dosen'])
                ->where('remedial_periode_id', $periodeTerpilih->id)
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

            // return response()->json($programstuditerpilih);

            if ($request->filled('search')) {
                $query->whereHas('kelaskuliah', function ($query) use ($request) {
                    $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                });
            }

            $daftarkelas = $query->paginate($request->get('perPage', 10));

            $total = $daftarkelas->total();

            return view(
                'remedial.pelaksanaan.kelas.index',
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
            $kelas = RemedialKelas::with(['remedialperiode', 'kelaskuliah', 'dosen', 'matakuliah', 'peserta'])
                ->where('id', $id)
                ->first();

            $peserta = RemedialKelasPeserta::with('mahasiswa')
                ->where('remedial_kelas_id', $id)
                ->get();

            $total = $peserta->count();

            return view(
                'remedial.pelaksanaan.kelas.detail.kelas',
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
            'remedial_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {
            $mk = RemedialAjuanDetail::with('RemedialAjuan')
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
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
                            'remedial_ajuan_id' => $item->remedial_ajuan_id,
                            'programstudi' => $item->RemedialAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->RemedialAjuan->nim, // Assuming you have a 'nim' field in RemedialAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_remedial' => $item->harga_remedial,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = RemedialKelas::create([
                    'remedial_periode_id' => $request->remedial_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    RemedialKelasPeserta::create([
                        'remedial_kelas_id' => $kelas->id,
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
            'remedial_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {

            $mk = RemedialAjuanDetail::with('RemedialAjuan')
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
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
                            'remedial_ajuan_id' => $item->remedial_ajuan_id,
                            'programstudi' => $item->RemedialAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->RemedialAjuan->nim, // Assuming you have a 'nim' field in RemedialAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_remedial' => $item->harga_remedial,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = RemedialKelas::create([
                    'remedial_periode_id' => $request->remedial_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    RemedialKelasPeserta::create([
                        'remedial_kelas_id' => $kelas->id,
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

            $query = RemedialKelas::with(['remedialperiode', 'kelaskuliah', 'dosen'])
                ->where('remedial_periode_id', $request->periodeTerpilih)
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
                'remedial_periode_id' => 'required|exists:remedial_periode,id',
                'file' => 'required|mimes:xls,xlsx'
            ]);

            $file = $request->file('file');
            $data = Excel::toArray([], $file);

            // return response()->json($data);

            $sukses = 0;
            $gagal = 0;

            array_shift($data[0]);

            foreach ($data[0] as $row) {
                // Jika kolom A kosong maka lewati
                if (empty($row[1]) || $row[1] == '' || $row[1] == null) {
                    break;
                } else {

                    $remedialKelas = RemedialKelas::where('kodemk', 'ilike', '%' . $row[4] . '%')
                        ->where('nip', 'ilike', '%' . $row[6] . '%')
                        ->where('remedial_periode_id', $request->remedial_periode_id)
                        ->first();

                    if ($remedialKelas) {
                        $kodeedlink = $row[9] ?? '';

                        $remedialKelas->update([
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
            $kelas = RemedialKelas::with(['remedialperiode', 'kelaskuliah', 'dosen', 'matakuliah', 'peserta'])
                ->where('id', $id)
                ->first();

            $peserta = DB::table('remedial_kelas_peserta')
                ->select('remedial_kelas_peserta.id', 'mhs.nim as mhs_nim', 'mhs.nama as mhs_nama', 'rp.kode_periode as kode_periode', 'krs.nhuruf as old_nhuruf', 'krs.nnumerik as old_nnumerik')
                ->leftJoin('mahasiswa as mhs', 'remedial_kelas_peserta.nim', '=', 'mhs.nim')
                ->leftJoin('remedial_kelas as rk', 'remedial_kelas_peserta.remedial_kelas_id', '=', 'rk.id')
                ->leftJoin('remedial_periode as rp', 'rk.remedial_periode_id', '=', 'rp.id')
                ->leftJoin('krs', function ($join) {
                    $join->on('remedial_kelas_peserta.nim', '=', 'krs.nim')
                        ->whereColumn('rk.kodemk', 'krs.idmk')
                        ->whereColumn('rp.kode_periode', 'krs.idperiode');
                })
                ->where('remedial_kelas_id', $id)
                ->groupBy('remedial_kelas_peserta.id', 'mhs.nim', 'mhs.nama', 'rp.kode_periode', 'krs.nhuruf', 'krs.nnumerik')
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

    // update remedialkelas
    public function updateRemedialKelas(Request $request)
    {
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data berhasil disimpan',
        //     'data' => 'Hello',
        // ]);
        try {
            $request->validate([
                'id' => 'required',
            ]);

            $remedialKelas = RemedialKelas::where('id', $request->id)->first();

            if ($remedialKelas) {
                $remedialKelas->update([
                    'kode_edlink' => $request->kode_edlink,
                    'catatan' => $request->catatan,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan',
                    'data' => $remedialKelas,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => null,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
