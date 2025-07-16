<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\BtqJadwal;
use App\Models\BtqJadwalMahasiswa;
use App\Models\BtqPenilaianMahasiswa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BtqJadwalController extends Controller
{
    //create
    public function create()
    {
        try {
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
            return view(
                'btq.jadwal.create',
                [
                    'daftar_periode' => $daftar_periode,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_periode' => 'required|string|max:255',
                'penguji_id'   => 'required|string|max:255',
                'kuota'        => 'required|numeric|min:1',
                // 'hari'         => 'required|string|max:255',
                'tanggal'      => 'required|date',
                'jam_mulai'    => 'required|date_format:H:i',
                'jam_selesai'  => 'required|date_format:H:i|after:jam_mulai',
                'ruang'        => 'required|string|max:255',
                'peserta'      => 'required|string|in:L,P', // Assuming L for male, P for female
                'is_active'    => 'required|string',
            ]);

            // Ambil hari dari tanggal
            $hari = Carbon::parse($validated['tanggal'])->isoFormat('dddd'); // Mengambil nama hari dalam bahasa lokal

            // Tambahkan hari ke dalam data yang akan disimpan
            $validated['hari'] = $hari;

            $jadwal = BtqJadwal::create($validated);

            return redirect()->route('btq')->with('message', 'Jadwal berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    public function daftarJadwal(Request $request)
    {
        try {
            // Lakukan paginasi langsung di query
            $daftar_jadwal = BtqJadwal::with(['periode', 'penguji'])
                ->where('is_active', "Aktif")  // Hanya menampilkan jadwal yang aktif
                ->where('peserta', Auth::user()->mahasiswa->jeniskelamin) // Menampilkan jadwal yang sesuai jenis kelamin mahasiswa
                ->whereDate('tanggal', '>=', now())
                ->orderBy('tanggal', 'asc')
                ->paginate($request->get('perPage', 10));

            // Memfilter data yang telah dipaginasi berdasarkan jumlahMahasiswaTerdaftar < kuota
            $filtered_jadwal = $daftar_jadwal->getCollection()->filter(function ($jadwal) {
                return $jadwal->jumlahMahasiswaTerdaftar() < $jadwal->kuota;
            });

            // Update koleksi paginasi dengan data yang sudah difilter
            $daftar_jadwal->setCollection($filtered_jadwal);

            // Menghitung total data yang sesuai filter (bukan total dari database)
            $total = $filtered_jadwal->count();

            // Jika user meminta response JSON (misalnya untuk API)
            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $daftar_jadwal, // Data yang dipaginasi setelah filter
                    'total' => $total,        // Total setelah filter
                ]);
            }

            // Ambil daftar periode
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            // Return view untuk rendering di browser
            return view('btq.jadwal.daftar-jadwal', [
                'data' => $daftar_jadwal,
                'total' => $total, // Total setelah filter
                'daftar_periode' => $daftar_periode,
            ]);
        } catch (\Exception $e) {
            // Mengembalikan pesan kesalahan
            return back()->with('message', "Terjadi kesalahan: " . $e->getMessage());
        }
    }


    //edit
    public function edit($id)
    {
        try {
            $jadwal = BtqJadwal::find($id);
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            // return response()->json($jadwal);
            return view(
                'btq.jadwal.edit',
                [
                    'jadwal' => $jadwal,
                    'daftar_periode' => $daftar_periode,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //update
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'kode_periode' => 'required|string|max:255',
                'penguji_id'   => 'required|string|max:255',
                'kuota'        => 'required|numeric|min:1',
                // 'hari'         => 'required|string|max:255',
                'tanggal'      => 'required|date',
                'jam_mulai'    => 'required|date_format:H:i',
                'jam_selesai'  => 'required|date_format:H:i|after:jam_mulai',
                'ruang'        => 'required|string|max:255',
                'peserta'      => 'required|string|in:L,P', // Assuming L for 
                'is_active'    => 'required|string',
            ]);

            // Ambil hari dari tanggal
            $hari = Carbon::parse($validated['tanggal'])->isoFormat('dddd'); // Mengambil nama hari dalam bahasa lokal

            // Tambahkan hari ke dalam data yang akan disimpan
            $validated['hari'] = $hari;

            $jadwal = BtqJadwal::find($id);
            $jadwal->update($validated);

            return back()->with('message', 'Jadwal berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // daftarPeserta
    public function daftarPeserta($id)
    {
        try {
            $jadwal = BtqJadwal::with(['mahasiswaTerdaftar.mahasiswa' => function ($query) {
                $query->orderBy('nim', 'asc'); // Urutkan berdasarkan NIM secara ascending
            }])->find($id);

            // Cek apakah sudah ada penilaian mahasiswa untuk jadwal ini
            $penilaianMahasiswaExists = BtqPenilaianMahasiswa::whereHas('btqJadwalMahasiswa', function ($query) use ($id) {
                $query->where('jadwal_id', $id);
            })->exists();

            // return response()->json($jadwal);
            return view(
                'btq.jadwal.peserta',
                [
                    'jadwal' => $jadwal,
                    'daftar_peserta' => $jadwal->mahasiswaTerdaftar ?? [],
                    'penilaianMahasiswaExists' => $penilaianMahasiswaExists,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
