<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BtqJadwalMahasiswa;
use App\Models\BtqJadwal;
use App\Models\BtqPenilaian;
use Illuminate\Support\Str;
use App\Models\BtqPenilaianMahasiswa;

class BtqJadwalMahasiswaController extends Controller
{
    //store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jadwal_id'     => 'required|string|max:255',
            ]);

            $jadwal = BtqJadwal::find($validated['jadwal_id']);

            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan.',
                ]);
            }

            $jumlahPeserta = $jadwal->jumlahMahasiswaTerdaftar();
            if ($jumlahPeserta >= $jadwal->kuota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota jadwal sudah penuh. Anda tidak bisa memilih jadwal ini.',
                ]);
            }

            $existing = BtqJadwalMahasiswa::where('jadwal_id', $validated['jadwal_id'])
                ->where('mahasiswa_id', auth()->user()->username)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di jadwal ini.',
                ]);
            }

            $existing_periode = BtqJadwalMahasiswa::where('mahasiswa_id', auth()->user()->username)
                ->join('btq_jadwal', 'btq_jadwal.id', '=', 'btq_jadwal_mahasiswa.jadwal_id')
                ->where('btq_jadwal.kode_periode', $jadwal->kode_periode)
                ->first();

            if ($existing_periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di jadwal periode ini.',
                ]);
            }

            $jadwalMahasiswa = BtqJadwalMahasiswa::create([
                'jadwal_id'     => $validated['jadwal_id'],
                'mahasiswa_id'  => auth()->user()->username,
            ]);

            $jadwal_id = $jadwalMahasiswa->id;

            $penilaian = BtqPenilaian::where('is_active', 1)->get();

            // Siapkan data untuk dimasukkan ke database
            $data = [];

            foreach ($penilaian as $pen) {
                $data[] = [
                    'id' => Str::uuid(),
                    'btq_penilaian_id' => $pen->id,
                    'btq_jadwal_mahasiswa_id' => $jadwal_id,
                    'jenis_penilaian' => $pen->jenis_penilaian,
                    'nilai' => 0,
                    'nilai_self' => 0,
                ];
            };

            BtqPenilaianMahasiswa::insert($data);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dipilih!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    // getpresensi
    public function getPresensi(Request $request)
    {
        try {
            $validated = $request->validate([
                'jadwal_id'     => 'required|string|max:255',
            ]);

            $daftarPeserta = BtqJadwalMahasiswa::with(['jadwal', 'mahasiswa'])
                ->where('jadwal_id', $validated['jadwal_id'])
                ->get();

            if ($daftarPeserta->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada peserta terdaftar untuk jadwal ini.'
                ], 404);
            }

            // Urutkan daftar peserta berdasarkan NIM mahasiswa setelah data diambil
            $daftarPeserta = $daftarPeserta->sortBy(function ($peserta) {
                return $peserta->mahasiswa->nim;
            })->values(); // Reindex setelah pengurutan

            // Return data peserta dan presensi dalam bentuk JSON
            return response()->json([
                'daftar_peserta' => $daftarPeserta
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    // save
    public function save(Request $request)
    {
        $request->validate([
            'presensi' => 'required|array', // Pastikan presensi adalah array
            'presensi.*.id' => 'required|uuid', // ID mahasiswa dalam array harus ada dan valid
            'presensi.*.hadir' => 'required',
            'penguji_id' => 'required' // Pastikan penguji_id dikirim
        ]);

        try {
            // Loop melalui setiap data presensi yang dikirim dari request
            foreach ($request->presensi as $data) {
                // Cari data presensi berdasarkan ID mahasiswa dalam BtqJadwalMahasiswa
                $btqJadwalMahasiswa = BtqJadwalMahasiswa::findOrFail($data['id']);

                // Update status presensi di model BtqJadwalMahasiswa
                $btqJadwalMahasiswa->presensi = $data['hadir']; // 1 = hadir, 0 = tidak hadir
                $btqJadwalMahasiswa->save(); // Simpan perubahan
            }

            return response()->json([
                'message' => 'Presensi berhasil disimpan.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}
