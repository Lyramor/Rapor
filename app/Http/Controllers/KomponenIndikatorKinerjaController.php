<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomponenIndikatorKinerja;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class KomponenIndikatorKinerjaController extends Controller
{
    //index function
    public function index()
    {
        //get all data from table komponen_indikator_kinerjas and order by urutan
        $data = KomponenIndikatorKinerja::orderBy('urutan', 'asc')->get();
        return view('komponen-indikator-kinerja.index', ['data' => $data]);
    }

    //create function
    public function create()
    {
        return view('komponen-indikator-kinerja.create');
    }

    //store function
    public function store(Request $request)
    {
        $data = $request->only('nama_indikator_kinerja', 'bobot', 'urutan', 'type_indikator');

        $validator = Validator::make($data, [
            'nama_indikator_kinerja' => 'required',
            'bobot' => 'required',
            'urutan' => 'required',
            'type_indikator' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/rapor/indikator-kinerja/create')->with('status', $validator->errors());
        }

        //store the data, method form is post and generate uuid for id
        KomponenIndikatorKinerja::create([
            'id' => Str::uuid(),
            'nama_indikator_kinerja' => $request->nama_indikator_kinerja,
            'bobot' => $request->bobot,
            'urutan' => $request->urutan,
            'type_indikator' => $request->type_indikator,
        ]);

        return redirect('/rapor/indikator-kinerja/create')->with('status', 'Komponen Indikator Kinerja created successfully');
    }

    //update function
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama_indikator_kinerja' => 'required',
            'bobot' => 'required',
            'urutan' => 'required',
            'type_indikator' => 'required',
        ]);

        // Temukan data indikator kinerja yang akan diupdate
        $indikatorKinerja = KomponenIndikatorKinerja::findOrFail($id);

        // Data tidak ditemukan
        if (!$indikatorKinerja) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Update data indikator kinerja
        $indikatorKinerja->update($validatedData);

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil diupdate'], 200);
    }

    //destroy function
    public function destroy($id)
    {
        // Temukan data indikator kinerja yang akan dihapus
        $indikatorKinerja = KomponenIndikatorKinerja::findOrFail($id);

        // Data tidak ditemukan
        if (!$indikatorKinerja) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data indikator kinerja
        $indikatorKinerja->delete();

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
