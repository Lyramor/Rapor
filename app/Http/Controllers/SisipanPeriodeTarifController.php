<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SisipanPeriodeTarif;
use App\Models\SisipanPeriode;
use App\Models\Periode;

class SisipanPeriodeTarifController extends Controller
{
    public function index(Request $request)
    {
        try {
            $dataSisipanPeriode = SisipanPeriode::with(['periode'])->where('id', $request->id)->first();
            $periode = Periode::orderBy('kode_periode', 'desc')->take(20)->get();
            $dataSisipanPeriodeTarif = SisipanPeriodeTarif::where('sisipan_periode_id', $request->id)->get();
            return view('sisipan.periode.rules.tarif', [
                'sisipanperiode' => $dataSisipanPeriode,
                'periode' => $periode,
                'data' => $dataSisipanPeriodeTarif,
                // 'data' => $dataSisipanPeriodeTarif,
                // 'total' => $total,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load Sisipan Periode Tarif.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'periode_angkatan' => 'required',
                'tarif' => 'required',
                'idSisipanPeriode' => 'required',
            ]);

            $data = [
                'sisipan_periode_id' => $request->idSisipanPeriode,
                'periode_angkatan' => $request->periode_angkatan,
                'tarif' => $request->tarif,
            ];

            SisipanPeriodeTarif::create($data);

            // return json
            return response()->json([
                'status' => 'success',
                'message' => 'Sisipan Periode Tarif created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sisipan Periode Tarif failed to create.' . $e->getMessage(),
            ]);
        }
    }

    // destroy
    public function destroy(Request $request)
    {
        try {
            $data = SisipanPeriodeTarif::find($request->id);
            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Sisipan Periode Tarif deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sisipan Periode Tarif failed to delete.' . $e->getMessage(),
            ]);
        }
    }
}
