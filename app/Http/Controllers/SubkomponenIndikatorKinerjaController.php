<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubkomponenIndikatorKinerjaController extends Controller
{
    public function index()
    {
        return view('subindikator-kinerja.index');
    }
}
