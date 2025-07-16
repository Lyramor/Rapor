<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SisipanPeriode;
use App\Helpers\UnitKerjaHelper;
use App\Models\SisipanPeriodeProdi;
use App\Models\UnitKerja;

class SisipanPeriodeProdiController extends Controller
{
    //index
    function index(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            $dataSisipanPeriode = SisipanPeriode::with(['periode'])->where('id', $request->id)->first();
            // $periode = Periode::orderBy('kode_periode', 'desc')->take(20)->get();
            $dataSisipanPeriodeProdi = SisipanPeriodeProdi::where('sisipan_periode_id', $request->id)->get();

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $dataSisipanPeriodeProdi,
            // ]);

            return view('sisipan.periode.rules.prodi', [
                'sisipanperiode' => $dataSisipanPeriode,
                'unitkerja' => $unitKerja,
                'data' => $dataSisipanPeriodeProdi,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load Sisipan Periode Tarif.');
        }
    }

    // store
    public function store(Request $request)
    {
        try {
            $request->validate([]);

            $data = [
                'sisipan_periode_id' => $request->idSisipanPeriode,
                'unit_kerja_id' => $request->unit_kerja_id,
                'nilai_batas' => $request->nilai_batas,
                'presensi_batas' => $request->presensi_batas,
                'batas_sks' => $request->batas_sks,
            ];

            SisipanPeriodeProdi::create($data);

            // return json
            return response()->json([
                'status' => 'success',
                'message' => 'Batas Nilai Sisipan created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Batas Nilai Sisipan failed to create.' . $e->getMessage(),
            ]);
        }
    }

    // destroy
    public function destroy(Request $request)
    {
        try {
            $data = SisipanPeriodeProdi::find($request->id);
            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Aturan Sisipan deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aturan Sisipan failed to delete.' . $e->getMessage(),
            ]);
        }
    }
}
