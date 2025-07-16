<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemedialPeriodeTarif;
use App\Models\RemedialPeriode;
use App\Models\Periode;

class RemedialPeriodeTarifController extends Controller
{
    public function index(Request $request)
    {
        try {
            $dataRemedialPeriode = RemedialPeriode::with(['periode'])->where('id', $request->id)->first();
            $periode = Periode::orderBy('kode_periode', 'desc')->take(20)->get();
            $dataRemedialPeriodeTarif = RemedialPeriodeTarif::where('remedial_periode_id', $request->id)->get();
            return view('remedial.periode.rules.tarif', [
                'remedialperiode' => $dataRemedialPeriode,
                'periode' => $periode,
                'data' => $dataRemedialPeriodeTarif,
                // 'data' => $dataRemedialPeriodeTarif,
                // 'total' => $total,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load Remedial Periode Tarif.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'periode_angkatan' => 'required',
                'tarif' => 'required',
                'idRemedialPeriode' => 'required',
            ]);

            $data = [
                'remedial_periode_id' => $request->idRemedialPeriode,
                'periode_angkatan' => $request->periode_angkatan,
                'tarif' => $request->tarif,
            ];

            RemedialPeriodeTarif::create($data);

            // return json
            return response()->json([
                'status' => 'success',
                'message' => 'Remedial Periode Tarif created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Remedial Periode Tarif failed to create.' . $e->getMessage(),
            ]);
        }
    }

    // destroy
    public function destroy(Request $request)
    {
        try {
            $data = RemedialPeriodeTarif::find($request->id);
            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Remedial Periode Tarif deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Remedial Periode Tarif failed to delete.' . $e->getMessage(),
            ]);
        }
    }
}
