<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    //store
    public function store(Request $request)
    {
        $request->validate([
            'nama_soal' => 'required',
            'keterangan' => 'required',
            'soal_acak' => 'required',
            'publik' => 'required',
        ]);

        // return $request->all();

        $soal = new Soal;
        $soal->nama_soal = $request->nama_soal;
        $soal->keterangan = $request->keterangan;
        $soal->soal_acak = $request->soal_acak;
        $soal->publik = $request->publik;
        $soal->save();

        return redirect()->route('soal.index')
            ->with('success', 'Soal created successfully.');
    }
}
