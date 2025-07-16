<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SisipanAjuan;
use App\Models\SisipanAjuanDetail;
use App\Models\SisipanPeriode;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UnitKerjaHelper;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Mahasiswa;
use App\Models\Krs;

class SisipanAjuanController extends Controller
{
    // index
    public function index(Request $request)
    {
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('gate');
        }

        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            $programstuditerpilih = null;

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

            $daftar_periode = SisipanPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = SisipanAjuan::with('sisipanajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('sisipan_periode_id', $periodeTerpilih->id)
                ->where('status_pembayaran', 'Menunggu Konfirmasi');

            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->where('programstudi', $programstudis->nama_unit);
                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search') && $request->get('search') != '') {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('nim', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('va', 'like', '%' . $request->get('search') . '%');
                });
            }

            $data_ajuan = $query->paginate($request->get('perPage', 10));

            $total = $data_ajuan->total();

            return view(
                'sisipan.ajuan.verifikasi',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    // 'programstudi' => $programstudi,
                    'unitkerja' => $unitKerja,
                    'data' => $data_ajuan,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
    // store
    public function store(Request $request)
    {
        try {
            $request->validate([
                'sisipan_periode_id' => 'required|exists:sisipan_periode,id',
                'nim' => 'required',
            ]);

            $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

            $periode = SisipanPeriode::with([
                'sisipanperiodetarif' => function ($query) use ($mahasiswa) {
                    $query->where('periode_angkatan', $mahasiswa->periodemasuk);
                }
            ])
                ->whereHas('sisipanperiodetarif', function ($query) use ($mahasiswa) {
                    $query->where('periode_angkatan', $mahasiswa->periodemasuk);
                })
                ->where('id', $request->sisipan_periode_id)
                ->first();

            if (!$periode) {
                return back()->with('message', 'Periode Sisipan untuk mahasiswa ' . $mahasiswa->periodemasuk . ' tidak memenuhi syarat');
            }

            $va = $periode->format_va;
            if ($periode->add_nrp) {
                $nim =  $mahasiswa->nim;
                // Menghapus digit ke-3 dan ke-4 dari NIM
                $modifiedNim = substr($nim, 0, 2) . substr($nim, 4);

                // Menggabungkan format_va dengan modifiedNim
                $va = $periode->format_va . $modifiedNim;
            }

            // Lakukan proses penyimpanan data ke sisipanajuan dan dapatkan id nya
            $sisipanAjuan = SisipanAjuan::create([
                'sisipan_periode_id' => $request->sisipan_periode_id,
                'nim' => $request->nim,
                'programstudi' => $mahasiswa->programstudi,
                'va' => $va,
                'tgl_pengajuan' => now(),
            ]);

            return redirect()->route('sisipan.ajuan.detail', $sisipanAjuan->id);
        } catch (\Exception $e) {
            return back()->with('message', 'Terjadi kesalahan' . $e->getMessage());
        }
    }


    // store ajuan sisipan detail
    public function ajuanDetailStore(Request $request)
    {
        try {
            // Lakukan validasi sesuai kebutuhan
            $request->validate([
                'krs' => 'required|array',
                'idmk' => 'required|array',
                'nama_kelas' => 'required|array',
                'nip' => 'required|array',
                'sisipan_ajuan_id' => 'required|exists:sisipan_ajuan,id',
            ]);

            // return response()->json($request->all());

            $sisipanAjuan = SisipanAjuan::find($request->sisipan_ajuan_id);

            $periode = SisipanPeriode::with([
                'sisipanperiodetarif' => function ($query) use ($sisipanAjuan) {
                    $query->where('periode_angkatan', $sisipanAjuan->mahasiswa->periodemasuk);
                }
            ])
                ->whereHas('sisipanperiodetarif', function ($query) use ($sisipanAjuan) {
                    $query->where('periode_angkatan', $sisipanAjuan->mahasiswa->periodemasuk);
                })
                ->where('id', $sisipanAjuan->sisipan_periode_id)
                ->first();

            if (!$periode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Periode sisipan tidak ditemukan',
                ]);
            }

            $totalKrs = count($request->krs);

            // Lakukan proses penyimpanan data ke sisipanajuandetail
            for ($i = 0; $i < $totalKrs; $i++) {
                SisipanAjuanDetail::create([
                    'sisipan_ajuan_id' => $request->sisipan_ajuan_id,
                    'krs_id' => $request->krs[$i],
                    'kode_periode' => $periode->kode_periode,
                    'idmk' => $request->idmk[$i],
                    'namakelas' => $request->nama_kelas[$i],
                    'nip' => $request->nip[$i],
                    'harga_sisipan' => $periode->sisipanperiodetarif[0]->tarif,
                    'status_ajuan' => 'Menunggu Konfirmasi',
                ]);
            }

            // update sisipan ajuan
            // $sisipanAjuan->update([
            //     'total_bayar' => $sisipanAjuan->total_bayar + $periode->sisipanperiodetarif[0]->tarif * $totalKrs,
            // ]);

            $this->updateTotalBayarAjuan($request->sisipan_ajuan_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $sisipanAjuan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }

    // deleteAjax
    public function deleteAjax($id)
    {
        try {
            // Temukan data sisipan ajuan yang akan dihapus
            $data = SisipanAjuan::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus bukti pembayaran dari storage jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // delete juga sisipanajuandetail
            $data->sisipanajuandetail()->delete();
            $data->delete();

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal
            return response()->json(['message' => 'Data gagal dihapus'], 500);
        }
    }

    //uploadBukti
    public function uploadBukti(Request $request)
    {
        try {
            // Lakukan validasi sesuai kebutuhan
            $request->validate([
                'sisipan_ajuan_id' => 'required|exists:sisipan_ajuan,id',
                'tgl_pembayaran' => 'required',
                'bukti_pembayaran' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
            ]);

            // Temukan data sisipan ajuan yang akan diupload bukti pembayaran
            $data = SisipanAjuan::findOrFail($request->sisipan_ajuan_id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus file bukti pembayaran sebelumnya jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // Simpan file bukti pembayaran
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '.' . $file->extension();
            // $file->move(public_path('bukti_pembayaran'), $fileName);
            $path = $file->storeAs('bukti_pembayaran', $fileName, 'public');

            // Update data sisipan ajuan dengan bukti pembayaran
            $data->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'Menunggu Konfirmasi',
                'tgl_pembayaran' => $request->tgl_pembayaran,
            ]);

            // Kirim respon berhasil
            return response()->json(['message' => 'Bukti pembayaran berhasil diupload'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal beserta $e->getMessage()
            return response()->json(['message' => 'Bukti pembayaran gagal diupload' .  $e->getMessage()], 500);
        }
    }

    //ajuandetail
    public function ajuandetail($id)
    {
        try {
            $data = SisipanAjuan::with([
                'sisipanajuandetail',
                'mahasiswa',
                'sisipanperiode',
                'sisipanperiode.sisipanperiodetarif',
                'sisipanperiode.sisipanperiodeprodi',
                'unitkerja'
            ])
                ->where('id', $id)
                ->first();

            // return response()->json($data);

            $periodeTerpilih = SisipanPeriode::with(
                [
                    'sisipanperiodetarif' => function ($query) use ($data) {
                        $query->where('periode_angkatan', $data->mahasiswa->periodemasuk);
                    },
                    'sisipanperiodeprodi' => function ($query) use ($data) {
                        $query->where('unit_kerja_id', $data->unitkerja->id);
                    }
                ]
            )
                ->whereHas('sisipanperiodetarif', function ($query) use ($data) {
                    $query->where('periode_angkatan', $data->mahasiswa->periodemasuk);
                })
                ->whereHas('sisipanperiodeprodi', function ($query) use ($data) {
                    $query->where('unit_kerja_id', $data->unitkerja->id);
                })
                ->where('kode_periode', $data->sisipanperiode->kode_periode)
                ->first();

            // return response()->json($periodeTerpilih);

            $data_krs = Krs::where('nim', $data->mahasiswa->nim)
                ->where('idperiode', '!=', $periodeTerpilih->kode_periode)
                ->orderBy('idperiode', 'asc')
                ->get()
                ->filter(function ($item) use ($periodeTerpilih) {
                    return (floatval($item->nnumerik) < $periodeTerpilih->sisipanperiodeprodi->first()->nilai_batas
                        && floatval($item->presensi) >= floatval($periodeTerpilih->sisipanperiodeprodi->first()->presensi_batas)) || $item->is_dispen == true;
                });

            if (!$data) {
                return back()->with('message', 'Data tidak ditemukan');
            }

            // return response()->json($data_krs);
            // return response()->json($data);
            return view('sisipan.ajuan.detail.ajuan-detail', [
                'data' => $data,
                'data_krs' => $data_krs,
                'periodeTerpilih' => $periodeTerpilih,
            ]);
        } catch (\Exception $e) {
            return back()->with('message', 'Data tidak ditemukan' . $e->getMessage());
        }
    }

    //ajuandetail data
    public function ajuandetaildata($id)
    {
        try {
            $data = SisipanAjuanDetail::with(['kelasKuliah', 'sisipanajuan', 'krs'])
                ->where('sisipan_ajuan_id', $id)
                ->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }


    // verifikasiajuan
    public function verifikasiAjuan(Request $request)
    {
        $validatedData = $request->validate([
            'sisipan_ajuan_id' => 'required',
            'jumlah_bayar' => 'required',
        ]);

        try {
            // get data sisipan ajuan id
            $sisipanAjuan = SisipanAjuan::find($request->sisipan_ajuan_id);

            // if data not found return response
            if (!$sisipanAjuan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // update status pembayaran
            $sisipanAjuan->update([
                'jumlah_bayar' => $request->jumlah_bayar,
                'status_pembayaran' => 'Lunas',
                'is_lunas' => 1,
                'verified_by' => auth()->user()->username,
            ]);

            // update status_ajuan sisipan ajuan detail where sisipan ajuan id
            SisipanAjuanDetail::where('sisipan_ajuan_id', $request->sisipan_ajuan_id)
                ->update([
                    'status_ajuan' => 'Konfirmasi Kelas',
                ]);

            return response()->json(['message' => 'Data berhasil diverifikasi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data gagal diverifikasi'], 500);
        }
    }

    // daftar ajuan
    public function daftarAjuan(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    // ->whereIn('unit_kerja_id', $unitKerjaIds)
                    // ->orWhere('unit_kerja_id', session('selected_filter'))
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = SisipanPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = SisipanAjuan::with('sisipanajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('sisipan_periode_id', $periodeTerpilih->id);

            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->where('programstudi', $programstudis->nama_unit);
                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search') && $request->get('search') != '') {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('nim', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('va', 'like', '%' . $request->get('search') . '%');
                });
            }

            if ($request->has('status_pembayaran')) {
                if ($request->get('status_pembayaran') != 'all') {
                    $query->where('status_pembayaran', $request->get('status_pembayaran'));
                }
            }

            $data_ajuan = $query->paginate($request->get('perPage', 10));

            // return response()->json($data_ajuan);

            $total = $data_ajuan->total();

            return view(
                'sisipan.ajuan.daftar-ajuan',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    // 'programstudi' => $programstudi,
                    'unitkerja' => $unitKerja,
                    'data' => $data_ajuan,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // uploadRekeningKoran
    public function uploadRekeningKoran(Request $request)
    {
        try {
            // request validation excel file
            $request->validate([
                'sisipan_periode_id' => 'required|exists:sisipan_periode,id',
                'file' => 'required|mimes:xls,xlsx'
            ]);

            // get file
            $file = $request->file('file');
            $data = Excel::toArray([], $file);

            $sukses = 0;
            $gagal = 0;

            // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
            array_shift($data[0]);

            foreach ($data[0] as $row) {
                // Jika kolom A kosong maka lewati
                if (empty($row[0]) || $row[0] == '' || $row[0] == null) {
                    break;
                } else {

                    $sisipanAjuan = SisipanAjuan::where('va', 'ilike', '%' . $row[2] . '%')
                        ->where('is_lunas', 0)
                        ->where('sisipan_periode_id', $request->sisipan_periode_id)
                        ->first();

                    if ($sisipanAjuan) {
                        if ($sisipanAjuan->jumlah_bayar + $row[3] == $sisipanAjuan->total_bayar) {
                            $sisipanAjuan->update([
                                'jumlah_bayar' => $sisipanAjuan->jumlah_bayar + $row[3],
                                'status_pembayaran' => 'Lunas',
                                'is_lunas' => 1,
                                'tgl_pembayaran' => Carbon::createFromTimestamp(($row[4] - 25569) * 86400)->format('Y-m-d'),
                                'verified_by' => auth()->user()->username,
                            ]);

                            $sisipanAjuan->sisipanajuandetail()->update([
                                'status_ajuan' => 'Konfirmasi Kelas',
                            ]);
                        } else {
                            $sisipanAjuan->update([
                                'jumlah_bayar' => $sisipanAjuan->jumlah_bayar + $row[3],
                                'status_pembayaran' => 'Menunggu Konfirmasi',
                                'is_lunas' => 0,
                                'tgl_pembayaran' => Carbon::createFromTimestamp(($row[4] - 25569) * 86400)->format('Y-m-d'),
                                'verified_by' => auth()->user()->username,
                            ]);
                        }
                        $sukses++;
                    } else {
                        // return back()->with('message', $row[2] . ' tidak ditemukan');
                        $gagal++;
                    }
                }
            }

            return back()->with('message', $sukses . ' data berhasil dieksekusi, ' . $gagal . ' data gagal dieksekusi');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // detailDelete
    public function detailDelete($id)
    {
        try {
            // Temukan data remedial ajuan yang akan dihapus
            $data = SisipanAjuanDetail::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $data->delete();

            $this->updateTotalBayarAjuan($data->sisipan_ajuan_id);

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal
            return response()->json(['message' => 'Data gagal dihapus'], 500);
        }
    }

    // updatetotalbayarSisipanAjuan
    public function updateTotalBayarAjuan($id)
    {
        try {
            $sisipanAjuan = SisipanAjuan::find($id);

            if (!$sisipanAjuan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $totalBayar = SisipanAjuanDetail::where('sisipan_ajuan_id', $id)->sum('harga_sisipan');

            $sisipanAjuan->update([
                'total_bayar' => $totalBayar,
            ]);

            return response()->json(['message' => 'Data berhasil diupdate'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data gagal diupdate'], 500);
        }
    }
}
