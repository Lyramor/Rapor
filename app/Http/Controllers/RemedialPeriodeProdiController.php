<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemedialPeriode;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialPeriodeProdi;
use App\Models\UnitKerja;

class RemedialPeriodeProdiController extends Controller
{
    //index
    function index(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            $dataRemedialPeriode = RemedialPeriode::with(['periode'])->where('id', $request->id)->first();
            // $periode = Periode::orderBy('kode_periode', 'desc')->take(20)->get();
            $dataRemedialPeriodeProdi = RemedialPeriodeProdi::where('remedial_periode_id', $request->id)->get();

            return view('remedial.periode.rules.prodi', [
                'remedialperiode' => $dataRemedialPeriode,
                'unitkerja' => $unitKerja,
                'data' => $dataRemedialPeriodeProdi,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load Remedial Periode Tarif.');
        }
    }

    // store
    public function store(Request $request)
    {
        try {
            $request->validate([]);

            $data = [
                'remedial_periode_id' => $request->idRemedialPeriode,
                'unit_kerja_id' => $request->unit_kerja_id,
                'nilai_batas' => $request->nilai_batas,
                'presensi_batas' => $request->presensi_batas,
            ];

            RemedialPeriodeProdi::create($data);

            // return json
            return response()->json([
                'status' => 'success',
                'message' => 'Batas Nilai Remedial created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Batas Nilai Remedial failed to create.' . $e->getMessage(),
            ]);
        }
    }

    // destroy
    public function destroy(Request $request)
    {
        try {
            $data = RemedialPeriodeProdi::find($request->id);
            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Aturan Remedial deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aturan Remedial failed to delete.' . $e->getMessage(),
            ]);
        }
    }
}
