<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responden;
use App\Models\KuesionerSDM;

class RespondenController extends Controller
{
    //

    // deleteAllResponden
    public function deleteAllResponden(Request $request)
    {
        $kuesioner_sdm = KuesionerSDM::find($request->get('kuesioner_sdm_id'));
        if (!$kuesioner_sdm) {
            return back()->with('error', 'Kuesioner SDM tidak ditemukan.');
        }

        $responden = Responden::where('kuesioner_sdm_id', $request->get('kuesioner_sdm_id'))->delete();

        return back()->with('message', 'Responden berhasil dihapus.');
    }
}
