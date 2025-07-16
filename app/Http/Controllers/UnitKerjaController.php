<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;

class UnitKerjaController extends Controller
{
    public function index()
    {
        // $unitKerjas = UnitKerja::with(['parentUnit'])->get();
        $unitKerjas = UnitKerja::with('childrenRecursive')->whereNull('parent_unit')->get();

        return response()->json([
            'success' => true,
            'data' => $unitKerjas
        ]);
    }

    public function getUnitKerja()
    {
        return response()->json(['message' => 'Hello, world!']);
    }

    public function getUnitKerjaByParent()
    {
        return response()->json(['message' => 'Hello, world!']);
    }
}
