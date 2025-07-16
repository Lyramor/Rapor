<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    //
    public function getNamaDosen(Request $request)
    {
        $query = $request->input('query');

        $namaDosen = Dosen::where(function ($q) use ($query) {
            $q->where('nip', 'ilike', "%{$query}%")
                ->orWhere('nama', 'ilike', "%{$query}%");
        })->select('nip', 'nama')->get();

        return response()->json($namaDosen);
    }
}
