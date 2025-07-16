<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\SisipanPeriode;
use App\Models\SisipanPeriodeTarif;
use App\Models\UnitKerja;

class SisipanPeriodeController extends Controller
{
    public function index(Request $request)
    {
        // // untuk dropdown unit kerja
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
        $unitKerjaIds = $this->getUnitKerjaIds();

        // Membuat query untuk mengambil data SisipanPeriode dengan filter unit kerja
        $query = SisipanPeriode::with(['periode'])->whereIn('unit_kerja_id', $unitKerjaIds)->orderBy('created_at', 'desc');

        // Melakukan pagination pada hasil query
        $dataSisipanPeriode = $query->paginate($request->get('perPage', 10));
        $periode = Periode::orderBy('kode_periode', 'desc')->take(25)->get();

        // Menghitung total data
        $total = $dataSisipanPeriode->total();

        return view('sisipan.periode.index', [
            'data' => $dataSisipanPeriode,
            'total' => $total,
            'unitkerja' => $unitKerja,
            'periode' => $periode
        ]);
    }

    public function create()
    {
        $periode = Periode::orderBy('kode_periode', 'desc')->take(25)->get();

        $unitkerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();

        // dd($unitkerja);
        // return response()->json($unitkerja);
        return view('sisipan.periode.create', [
            'periode' => $periode,
            'unitkerja' => $unitkerja
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_periode' => 'required',
                'unit_kerja_id' => 'required',
                'nama_periode' => 'required',
                'format_va' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date'
            ]);

            $add_nrp = $request->add_nrp ? true : false;
            $is_aktif = $request->is_aktif ? true : false;

            $data = [
                'unit_kerja_id' => $request->unit_kerja_id,
                'kode_periode' => $request->kode_periode,
                'nama_periode' => $request->nama_periode,
                'format_va' => $request->format_va,
                'add_nrp' => $add_nrp,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_aktif' => $is_aktif,
            ];

            SisipanPeriode::create($data);

            return redirect()->back()
                ->with('message', 'Sisipan Periode created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('message', 'Sisipan Periode failed to create.' . $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $periode = Periode::orderBy('kode_periode', 'desc')->take(25)->get();
        $unitkerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();

        // return response()->json($unitkerja);
        $data = SisipanPeriode::with('unitkerja')->where('id', $uuid)->first();
        return view('sisipan.periode.edit', [
            'data' => $data,
            'periode' => $periode,
            'unitkerja' => $unitkerja
        ]);
    }

    public function update(Request $request, $uuid)
    {
        try {
            $request->validate([
                'unit_kerja_id' => 'required',
                'kode_periode' => 'required',
                'nama_periode' => 'required',
                'format_va' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
            ]);

            $is_aktif = $request->is_aktif ? true : false;
            $add_nrp = $request->add_nrp ? true : false;

            $data = [
                'unit_kerja_id' => $request->unit_kerja_id,
                'kode_periode' => $request->kode_periode,
                'nama_periode' => $request->nama_periode,
                'format_va' => $request->format_va,
                'add_nrp' =>  $add_nrp,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_aktif' => $is_aktif,
            ];

            SisipanPeriode::where('id', $uuid)->update($data);

            // return redirect()->route('sisipan.periode')
            return redirect()->back()
                ->with('message', 'Sisipan Periode updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('message', 'Sisipan Periode failed to update.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Temukan data indikator kinerja yang akan dihapus
            $data = SisipanPeriode::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $data->delete();

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal
            return response()->json(['message' => 'Data gagal dihapus'], 500);
        }
    }

    protected function getUnitKerjaIds()
    {
        // Mengambil unit kerja yang dipilih dari session
        $selectedUnitKerjaId = session('selected_filter');

        // Mengambil unit kerja beserta child unitnya
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();

        // Membuat array unit kerja ID untuk filter
        $unitKerjaIds = $datafilter->pluck('id')->toArray();

        // Menambahkan ID dari child unit ke dalam array unit kerja ID
        foreach ($datafilter as $unitKerja) {
            $unitKerjaIds = array_merge($unitKerjaIds, $unitKerja->childUnit->pluck('id')->toArray());
        }

        return $unitKerjaIds;
    }

    // salinPeriode
    public function salinPeriode(Request $request)
    {
        try {
            // Validasi data input jika diperlukan
            $request->validate([
                'old_periode_id' => 'required',
                'kode_periode' => 'required',
                'unit_kerja_id' => 'required',
                'nama_periode' => 'required',
            ]);

            // Ambil data periode lama
            $oldPeriode = SisipanPeriode::findOrFail($request->old_periode_id);

            // Buat data baru
            $newPeriode = new SisipanPeriode();
            $newPeriode->unit_kerja_id = $request->unit_kerja_id;
            $newPeriode->kode_periode = $request->kode_periode;
            $newPeriode->nama_periode = $request->nama_periode;
            $newPeriode->format_va = $oldPeriode->format_va;
            $newPeriode->tanggal_mulai = $oldPeriode->tanggal_mulai;
            $newPeriode->tanggal_selesai = $oldPeriode->tanggal_selesai;
            $newPeriode->nilai_batas = $oldPeriode->nilai_batas;
            $newPeriode->is_aktif = $oldPeriode->is_aktif;
            $newPeriode->save();

            // SisipanPeriodeTarif
            $listOldTarif = SisipanPeriodeTarif::where('sisipan_periode_id', $oldPeriode->id)->get();
            foreach ($listOldTarif as $oldTarif) {
                $newTarif = new SisipanPeriodeTarif();
                $newTarif->sisipan_periode_id = $newPeriode->id;
                $newTarif->periode_angkatan = $oldTarif->periode_angkatan;
                $newTarif->tarif = $oldTarif->tarif;
                $newTarif->save();
            }

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil disalin' . $newPeriode->id], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak valid' . $e->getMessage()], 400);
        }
    }
}
