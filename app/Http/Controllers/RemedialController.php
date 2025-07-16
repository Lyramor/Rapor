<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialAjuan;
use App\Models\RemedialPeriode;


class RemedialController extends Controller
{
    public function index()
    {
        // echo session('selected_filter');
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('remedial.mahasiswa');
        } elseif (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas') {
            return $this->dashboardFakultas(new Request());
        } elseif (session('selected_role') == 'Admin Prodi') {
            return $this->dashboardProdi(new Request());
        } elseif (session('selected_role') == 'DHMD') {
            return redirect()->route('remedial.pelaksanaan');
        } else {
            return redirect()->route('login');
        }
    }

    public function dashboardFakultas(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->whereIn('unit_kerja_id', $unitKerjaIds)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if (!$periodeTerpilih) {
                return redirect()->back()->with('message', 'Periode Remedial tidak ditemukan');
            }

            $daftar_periode = RemedialPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $daftar_ajuan = RemedialAjuan::with('remedialajuandetail')
                ->where('remedial_periode_id',  $periodeTerpilih->id)
                ->get()
                ->groupBy('programstudi')
                ->map(function ($items, $key) {
                    $totalBayar = $items->sum('total_bayar');
                    $totalAjuan = $items->count();
                    $jumlahAjuanDetail = $items->reduce(function ($carry, $item) {
                        return $carry + $item->remedialajuandetail->count();
                    }, 0);
                    $totalMenungguPembayaran = $items->where('status_pembayaran', 'Menunggu Pembayaran')->count();
                    $totalMenungguKonfirmasi = $items->where('status_pembayaran', 'Menunggu Konfirmasi')->count();
                    $totalLunas = $items->where('status_pembayaran', 'Lunas')->count();
                    $totalDitolak = $items->where('status_pembayaran', 'Ditolak')->count();
                    return [
                        'data' => $items,
                        'total_tagihan' => $totalBayar,
                        'total_bayar' => $items->sum('jumlah_bayar'),
                        'total_ajuan' => $totalAjuan,
                        'jumlah_ajuan_detail' => $jumlahAjuanDetail,
                        'total_menunggu_pembayaran' => $totalMenungguPembayaran,
                        'total_menunggu_konfirmasi' => $totalMenungguKonfirmasi,
                        'total_lunas' => $totalLunas,
                        'total_ditolak' => $totalDitolak
                    ];
                });

            $rekap = $this->hitungRekapSemua($daftar_ajuan);

            return view(
                'remedial.dashboard',
                [
                    'unitKerja' => $unitKerja,
                    'periodeTerpilih' => $periodeTerpilih,
                    'daftar_periode' => $daftar_periode,
                    'daftar_ajuan' => $daftar_ajuan,
                    'rekap' => $rekap
                ]
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function dashboardProdi(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaParentId = UnitKerjaHelper::getUnitKerjaParentId();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->where('unit_kerja_id', $unitKerjaParentId)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = RemedialPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerjaParentId)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $daftar_ajuan = RemedialAjuan::with('remedialajuandetail')
                ->where('remedial_periode_id', $periodeTerpilih->id)
                ->where('programstudi', $unitKerja->first()->nama_unit)
                ->get()
                ->groupBy('programstudi')
                ->map(function ($items, $key) {
                    $totalBayar = $items->sum('total_bayar');
                    $totalAjuan = $items->count();
                    $jumlahAjuanDetail = $items->reduce(function ($carry, $item) {
                        return $carry + $item->remedialajuandetail->count();
                    }, 0);
                    $totalMenungguPembayaran = $items->where('status_pembayaran', 'Menunggu Pembayaran')->count();
                    $totalMenungguKonfirmasi = $items->where('status_pembayaran', 'Menunggu Konfirmasi')->count();
                    $totalLunas = $items->where('status_pembayaran', 'Lunas')->count();
                    $totalDitolak = $items->where('status_pembayaran', 'Ditolak')->count();
                    return [
                        'data' => $items,
                        'total_tagihan' => $totalBayar,
                        'total_bayar' => $items->sum('jumlah_bayar'),
                        'total_ajuan' => $totalAjuan,
                        'jumlah_ajuan_detail' => $jumlahAjuanDetail,
                        'total_menunggu_pembayaran' => $totalMenungguPembayaran,
                        'total_menunggu_konfirmasi' => $totalMenungguKonfirmasi,
                        'total_lunas' => $totalLunas,
                        'total_ditolak' => $totalDitolak
                    ];
                });

            $rekap = $this->hitungRekapSemua($daftar_ajuan);

            return view(
                'remedial.dashboard',
                [
                    'unitKerja' => $unitKerja,
                    'periodeTerpilih' => $periodeTerpilih,
                    'daftar_periode' => $daftar_periode,
                    'daftar_ajuan' => $daftar_ajuan,
                    'rekap' => $rekap
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // hitungRekapSemua
    public function hitungRekapSemua($daftar_ajuan)
    {
        $rekap_semua = [];
        $rekap_semua['total_tagihan_semua'] = 0;
        $rekap_semua['total_bayar_semua'] = 0;
        $rekap_semua['total_ajuan_semua'] = 0;
        $rekap_semua['jumlah_ajuan_detail_semua'] = 0;
        $rekap_semua['total_menunggu_pembayaran_semua'] = 0;
        $rekap_semua['total_menunggu_konfirmasi_semua'] = 0;
        $rekap_semua['total_lunas_semua'] = 0;
        $rekap_semua['total_ditolak_semua'] = 0;

        foreach ($daftar_ajuan as $key => $value) {
            foreach ($value['data'] as $item) {
                $rekap_semua['total_tagihan_semua'] += $item->total_bayar;
                $rekap_semua['total_bayar_semua'] += $item->jumlah_bayar;
                $rekap_semua['total_ajuan_semua'] += 1;
                $rekap_semua['jumlah_ajuan_detail_semua'] += $item->remedialajuandetail->count();
                $rekap_semua['total_menunggu_pembayaran_semua'] += $item->status_pembayaran == 'Menunggu Pembayaran' ? 1 : 0;
                $rekap_semua['total_menunggu_konfirmasi_semua'] += $item->status_pembayaran == 'Menunggu Konfirmasi' ? 1 : 0;
                $rekap_semua['total_lunas_semua'] += $item->status_pembayaran == 'Lunas' ? 1 : 0;
                $rekap_semua['total_ditolak_semua'] += $item->status_pembayaran == 'Ditolak' ? 1 : 0;
            }
        }

        return $rekap_semua;
    }
}
