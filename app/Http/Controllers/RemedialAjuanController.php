<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UnitKerjaHelper;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class RemedialAjuanController extends Controller
{
    // index
    public function index(Request $request)
    {
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('gate');
        }

        //create if

        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            $programstuditerpilih = null;

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('unit_kerja_id', $unitKerja->id)
                    ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = RemedialPeriode::with('periode')->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $query = RemedialAjuan::with('remedialajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('remedial_periode_id', $periodeTerpilih->id)
                ->where('status_pembayaran', 'Menunggu Konfirmasi')
                ->orderBy('tgl_pembayaran', 'desc');

            //filter terkait dengan program studi
            if ($request->filled('programstudi')) {

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
                'remedial.ajuan.verifikasi',
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

    // daftar ajuan
    public function daftarAjuan(Request $request)
    {
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('gate');
        }
        
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            // return response()->json($unitKerja);

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            // request periodeterpilih filled
            if ($request->filled('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::where('unit_kerja_id', $unitKerja->id)
                    ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }


            $daftar_periode = RemedialPeriode::with('periode')->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $query = RemedialAjuan::with('remedialajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('remedial_periode_id', $periodeTerpilih->id);

            //filter terkait dengan program studi
            if ($request->filled('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    if ($programstudis->jenis_unit == 'Program Studi') {
                        $query->where('programstudi', $programstudis->nama_unit);
                    } else {
                        $query->whereIn('programstudi', $unitKerjaNames);
                    }

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

            $total = $data_ajuan->total();

            return view(
                'remedial.ajuan.daftar-ajuan',
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
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    // store via ajax
    public function storeAjax(Request $request)
    {
        try {
            // Lakukan validasi sesuai kebutuhan
            $request->validate([
                'krs' => 'required|array',
                'idmk' => 'required|array',
                'nama_kelas' => 'required|array',
                'nip' => 'required|array',
                'remedial_periode_id' => 'required|exists:remedial_periode,id',
            ]);

            $user = auth()->user()->mahasiswa;

            $periode = RemedialPeriode::with([
                'remedialperiodetarif' => function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                }
            ])
                ->whereHas('remedialperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->where('id', $request->remedial_periode_id)
                ->first();

            if (!$periode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Periode remedial tidak ditemukan',
                ]);
            }

            $totalKrs = count($request->krs);

            $va = $periode->format_va;
            if ($periode->add_nrp) {
                $va = $periode->format_va . auth()->user()->username;
            }


            // Lakukan proses penyimpanan data ke remedialajuan dan dapatkan id nya
            $remedialAjuan = RemedialAjuan::create([
                'remedial_periode_id' => $request->remedial_periode_id,
                'nim' => auth()->user()->username,
                'programstudi' => auth()->user()->mahasiswa->programstudi,
                'va' => $va,
                'total_bayar' => $totalKrs * $periode->remedialperiodetarif[0]->tarif,
                'tgl_pengajuan' => now(),
            ]);

            // Lakukan proses penyimpanan data ke remedialajuandetail
            for ($i = 0; $i < $totalKrs; $i++) {
                RemedialAjuanDetail::create([
                    'remedial_ajuan_id' => $remedialAjuan->id,
                    'kode_periode' => $periode->kode_periode,
                    'krs_id' => $request->krs[$i],
                    'idmk' => $request->idmk[$i],
                    'namakelas' => $request->nama_kelas[$i],
                    'nip'  => $request->nip[$i],
                    'harga_remedial' => $periode->remedialperiodetarif[0]->tarif,
                    'status_ajuan' => 'Konfirmasi Pembayaran',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $remedialAjuan,
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
            // Temukan data remedial ajuan yang akan dihapus
            $data = RemedialAjuan::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus bukti pembayaran dari storage jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // delete juga remedialajuandetail
            $data->remedialajuandetail()->delete();
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
                'remedial_ajuan_id' => 'required|exists:remedial_ajuan,id',
                'tgl_pembayaran' => 'required',
                'bukti_pembayaran' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
            ]);

            // Temukan data remedial ajuan yang akan diupload bukti pembayaran
            $data = RemedialAjuan::findOrFail($request->remedial_ajuan_id);

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

            // Update data remedial ajuan dengan bukti pembayaran
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
            $data = RemedialAjuanDetail::with(['kelasKuliah', 'remedialajuan', 'krs'])
                ->where('remedial_ajuan_id', $id)
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
            'remedial_ajuan_id' => 'required',
            'jumlah_bayar' => 'required',
        ]);

        try {
            // get data remedial ajuan id
            $remedialAjuan = RemedialAjuan::find($request->remedial_ajuan_id);

            // if data not found return response
            if (!$remedialAjuan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // update status pembayaran
            $remedialAjuan->update([
                'jumlah_bayar' => $request->jumlah_bayar,
                'status_pembayaran' => 'Lunas',
                'is_lunas' => 1,
                'verified_by' => auth()->user()->username,
            ]);

            // update status_ajuan remedial ajuan detail where remedial ajuan id
            RemedialAjuanDetail::where('remedial_ajuan_id', $request->remedial_ajuan_id)
                ->update([
                    'status_ajuan' => 'Konfirmasi Kelas',
                ]);

            return response()->json(['message' => 'Data berhasil diverifikasi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data gagal diverifikasi'], 500);
        }
    }

    // uploadRekeningKoran
    public function uploadRekeningKoran(Request $request)
    {
        try {
            // request validation excel file
            $request->validate([
                'remedial_periode_id' => 'required|exists:remedial_periode,id',
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

                    $remedialAjuan = RemedialAjuan::where('va', 'ilike', '%' . $row[2] . '%')
                        ->where('is_lunas', 0)
                        ->where('remedial_periode_id', $request->remedial_periode_id)
                        ->first();

                    if ($remedialAjuan) {
                        if ($remedialAjuan->jumlah_bayar + $row[3] == $remedialAjuan->total_bayar) {
                            $remedialAjuan->update([
                                'jumlah_bayar' => $remedialAjuan->jumlah_bayar + $row[3],
                                'status_pembayaran' => 'Lunas',
                                'is_lunas' => 1,
                                'tgl_pembayaran' => Carbon::createFromTimestamp(($row[4] - 25569) * 86400)->format('Y-m-d'),
                                'verified_by' => auth()->user()->username,
                            ]);

                            $remedialAjuan->remedialajuandetail()->update([
                                'status_ajuan' => 'Konfirmasi Kelas',
                            ]);
                        } else {
                            $remedialAjuan->update([
                                'jumlah_bayar' => $remedialAjuan->jumlah_bayar + $row[3],
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
}
