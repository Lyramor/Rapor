<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function getNamaSiswa(Request $request)
    {
        $query = $request->input('query');

        $namaSiswa = Mahasiswa::where(function ($q) use ($query) {
            $q->where('nim', 'ilike', "%{$query}%")
                ->orWhere('nama', 'ilike', "%{$query}%");
        })->select('nim', 'nama')->get();

        return response()->json($namaSiswa);
        // $query = $request->input('query');
        // $programStudi = $request->input('program_studi');

        // $namaSiswa = Mahasiswa::where(function ($q) use ($query) {
        //     $q->where('nim', 'ilike', "%{$query}%")
        //         ->orWhere('nama', 'ilike', "%{$query}%");
        // })
        //     ->when($request->has('program_studi'), function ($q) use ($programStudi) {
        //         return $q->where('programstudi', $programStudi);
        //     })
        //     ->select('nim', 'nama')
        //     ->get();

        // return response()->json($namaSiswa);
    }
}
