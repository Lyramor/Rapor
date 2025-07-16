<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SisipanPeriode;
use App\Models\Krs;
use App\Models\SisipanAjuan;
use App\Helpers\UnitKerjaHelper;
use App\Models\UnitKerja;
use App\Models\SisipanKelasPeserta;

class SisipanMahasiswaController extends Controller
{
    // index
    public function index(Request $request)
    {
        $user = auth()->user()->mahasiswa;

        $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

        // return response()->json($user);
        if ($request->has('periodeTerpilih')) {
            $periodeTerpilih = SisipanPeriode::with(
                [
                    'sisipanperiodetarif' => function ($query) use ($user) {
                        $query->where('periode_angkatan', $user->periodemasuk);
                    },
                    'sisipanperiodeprodi' => function ($query) use ($user) {
                        $query->where('unit_kerja_id', session('selected_filter'));
                    }
                ]
            )
                ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->where('kode_periode', $request->periodeTerpilih)
                ->first();
        } else {
            $periodeTerpilih = SisipanPeriode::with([
                'sisipanperiodetarif' => function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                },
                'sisipanperiodeprodi' => function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                }
            ])
                ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$periodeTerpilih) {
            return back()->with('message', 'Periode sisipan untuk ' . $user->periodemasuk . ' belum tersedia');
        }

        $daftar_periode = SisipanPeriode::with(['sisipanperiodetarif', 'sisipanperiodeprodi'])
            ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                $query->where('periode_angkatan', $user->periodemasuk);
            })
            ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
                $query->where('unit_kerja_id', session('selected_filter'));
            })
            // ->whereIn('unit_kerja_id', $unitKerjaIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // return response()->json($daftar_periode);

        $data_krs = Krs::where('idperiode', $periodeTerpilih->kode_periode)
            ->where('nim', $user->nim)
            ->get()
            ->filter(function ($item) use ($periodeTerpilih) {
                return floatval($item->nnumerik) < $periodeTerpilih->sisipanperiodeprodi->first()->nilai_batas
                    && floatval($item->presensi) >= floatval($periodeTerpilih->sisipanperiodeprodi->first()->presensi_batas);
            });

        // return response()->json($data_krs);
        // 
        $data_ajuan = SisipanAjuan::with('sisipanajuandetail')->where('nim', auth()->user()->username)
            ->where('sisipan_periode_id', $periodeTerpilih->id)
            ->get();

        return view('sisipan.mahasiswa.dashboard', [
            'daftar_periode' => $daftar_periode,
            'periodeTerpilih' => $periodeTerpilih,
            'data_krs' => $data_krs,
            'data_ajuan' => $data_ajuan,
        ]);
    }


    // fungsi getKelas
    public function getKelas(Request $request)
    {
        try {
            $user = auth()->user()->mahasiswa;
            // return response()->json($user);
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

            $query = SisipanKelasPeserta::with(['sisipanKelas', 'sisipanKelas.kelaskuliah', 'sisipanKelas.dosen'])
                ->where('nim', $user->nim)
                ->whereHas('sisipanKelas', function ($query) use ($periodeTerpilih) {
                    $query->where('sisipan_periode_id', $periodeTerpilih->id);
                });

            if ($request->filled('search')) {
                $query->whereHas('matakuliah', function ($query) use ($request) {
                    $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                });
            }

            $pesertaKelas = $query->paginate($request->get('perPage', 10));

            // return response()->json($pesertaKelas);

            $total = $pesertaKelas->total();

            return view(
                'sisipan.mahasiswa.kelas',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'unitkerja' => $unitKerja,
                    'data' => $pesertaKelas,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
