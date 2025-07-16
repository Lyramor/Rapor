<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\ProgramStudi;
use App\Models\Rapor;
use App\Models\Soal;


class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $dataSoal = Soal::with(['pertanyaan'])->orderBy('created_at', 'desc')->paginate($request->get('perPage', 10));
        $total = $dataSoal->total(); // Mendapatkan total data?

        if($dataSoal == null){
            $dataSoal = [];
        }
        // $total = 0;

        // return response()->json($dataRapor);
        return view('kuesioner.banksoal.index', [
            'data' => $dataSoal,
            'total' => $total,
        ]);
    }

    public function create()
    {
        return view('kuesioner.banksoal.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama_soal' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        try {
            // Simpan data ke dalam database
            $soal = new Soal();
            $soal->nama_soal = $validatedData['nama_soal'];
            $soal->keterangan = $validatedData['keterangan'];
            $soal->soal_acak = $request->has('soal_acak'); // Mengambil nilai boolean dari checkbox 'soal_acak'
            $soal->publik = $request->has('publik'); // Mengambil nilai boolean dari checkbox 'publik'
            $soal->save();

            // Jika berhasil disimpan, kembalikan response
            return back()->with('message', "Data soal berhasil disimpan");
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, kembalikan response error
            return back()->with('message', "Gagal menyimpan data soal: ");
        }
    }

    public function show($id)
    {
        // $id to string
        $id = (string) $id;
        try {
            $soal = Soal::find($id);
            if ($soal) {
                return view('kuesioner.banksoal.show', [
                    'data' => $soal,
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    // destroy
    public function destroy($id)
    {
        // Temukan data indikator kinerja yang akan dihapus
        $soal = Soal::findOrFail($id);

        // Data tidak ditemukan
        if (!$soal) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data indikator kinerja
        $soal->delete();

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    public function getAllDataSoal(Request $request)
    {
        $query = $request->input('query');

        $soal = Soal::where(function ($q) use ($query) {
            $q->where('nama_soal', 'ilike', "%{$query}%");
        })->select('id', 'nama_soal')->get();

        return response()->json($soal);
    }

    public function getDataSoal(Request $request)
    {
        $soal = Soal::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $query->where('nama_soal', 'ilike', "%$search%");
            });
        })
            ->with('pertanyaan')
            ->paginate($request->get('perPage', 10));

        return response()->json($soal);
    }
}
