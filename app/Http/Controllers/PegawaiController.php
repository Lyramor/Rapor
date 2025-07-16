<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PegawaiController extends Controller
{
    //
    public function getNamaPegawai(Request $request)
    {
        $query = $request->input('query');

        $namaPegawai = Pegawai::where(function ($q) use ($query) {
            $q->where('nip', 'ilike', "%{$query}%")
                ->orWhere('nama', 'ilike', "%{$query}%");
        })->select('nip', 'nama')->get();

        return response()->json($namaPegawai);
    }

    public function getDataPegawai(Request $request)
    {
        // Menentukan jumlah data per halaman
        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // $daftarPegawai  = Pegawai::with('unitKerja')->paginate(10);
        $daftarPegawai = Pegawai::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where('nama', 'ilike', "%$search%")->orWhere('nip', 'ilike', "%$search%");
        })->with('unitKerja')->paginate($perPage);

        return response()->json($daftarPegawai);
    }

    public function getDataResponden(Request $request)
    {
        // Menentukan jumlah data per halaman
        $perPage = $request->has('limit') ? $request->get('limit') : 1000;

        $daftarPegawai = Pegawai::when($request->has('unit_kerja'), function ($query) use ($request) {
            $query->where('unit_kerja_id', $request->get('unit_kerja'));
        })->when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where('nama', 'ilike', "%$search%");
        })->with('unitKerja')->paginate($perPage);

        return response()->json($daftarPegawai);
    }
}
