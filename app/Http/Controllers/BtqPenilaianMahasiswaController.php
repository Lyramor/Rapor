<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BtqJadwalMahasiswa;
use App\Models\BtqPenilaian;
use App\Models\BtqPenilaianMahasiswa;
use App\Models\BtqJadwal;
use Illuminate\Support\Str;
use Exception;

class BtqPenilaianMahasiswaController extends Controller
{
    public function generatePenilaian(Request $request)
    {
        try {
            // Validasi input jadwal_id
            $validated = $request->validate([
                'jadwal_id' => 'required',
            ]);

            // Cari jadwal, jika tidak ditemukan akan otomatis melemparkan 404
            $jadwal = BtqJadwal::findOrFail($validated['jadwal_id']);

            // Cek apakah ada mahasiswa yang terdaftar pada jadwal
            $jadwalMahasiswaExists = BtqJadwalMahasiswa::where('jadwal_id', $jadwal->id)->exists();

            if (!$jadwalMahasiswaExists) {
                return response()->json(['message' => 'Tidak ada mahasiswa yang terdaftar pada jadwal ini'], 404);
            }

            // Hapus data BtqPenilaianMahasiswa yang sudah ada untuk jadwal ini
            BtqPenilaianMahasiswa::whereHas('btqJadwalMahasiswa', function ($query) use ($jadwal) {
                $query->where('jadwal_id', $jadwal->id);
            })->delete();

            // Ambil data mahasiswa yang terdaftar pada jadwal tersebut
            $jadwalMahasiswa = BtqJadwalMahasiswa::where('jadwal_id', $jadwal->id)->get();

            // Ambil penilaian yang aktif
            $penilaian = BtqPenilaian::where('is_active', 1)->get();

            // Siapkan data untuk dimasukkan ke database
            $data = $jadwalMahasiswa->flatMap(function ($item) use ($penilaian) {
                return $penilaian->map(function ($pen) use ($item) {
                    return [
                        'id' => Str::uuid(),
                        'btq_penilaian_id' => $pen->id,
                        'btq_jadwal_mahasiswa_id' => $item->id,
                        'jenis_penilaian' => $pen->jenis_penilaian,
                        'nilai' => 0,
                        'nilai_self' => 0,
                    ];
                });
            })->toArray();

            // Masukkan data ke database
            BtqPenilaianMahasiswa::insert($data);

            // Jika berhasil, kirimkan respons sukses
            return response()->json(['message' => 'Penilaian berhasil digenerate'], 200);
        } catch (Exception $e) {
            // Jika ada error yang tidak terduga, kirimkan respons error
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengenerate penilaian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // getdatapenilaian
    public function getPenilaian(Request $request)
    {
        try {
            // Ambil data penilaian dengan relasi dan pengurutan
            $penilaian = BtqPenilaianMahasiswa::with(['btqPenilaian' => function ($query) {
                $query->orderBy('no_urut', 'asc'); // Urutkan berdasarkan no_urut dari relasi btqPenilaian
            }])
                ->where('btq_jadwal_mahasiswa_id', $request->jadwal_mahasiswa_id)
                ->whereHas('btqPenilaian', function ($query) use ($request) {
                    $query->where('jenis_penilaian', $request->jenis_penilaian);
                })
                ->get();

            // Setelah data diambil, urutkan kembali berdasarkan kolom no_urut dari relasi btqPenilaian
            $penilaian = $penilaian->sortBy(function ($item) {
                return $item->btqPenilaian->no_urut; // Urutkan berdasarkan no_urut dari relasi btqPenilaian
            });

            // Reindex urutan koleksi
            $penilaian = $penilaian->values(); // Mengembalikan koleksi yang sudah diurutkan dan reindex urutannya

            // Kembalikan respons dalam bentuk JSON
            return response()->json(['penilaian' => $penilaian], 200);
        } catch (\Exception $e) {
            // Jika terjadi error, tangkap exception dan kembalikan respons error
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat mengambil data penilaian.',
                'details' => $e->getMessage() // Hanya untuk debugging, bisa dihapus di production
            ], 500);
        }
    }

    public function savePenilaian(Request $request)
    {
        try {
            $penilaianData = $request->input('penilaian', []);
            $penguji_id = $request->input('penguji_id'); // Ambil penguji_id

            // Loop melalui semua data penilaian yang dikirimkan
            foreach ($penilaianData as $penilaian) {
                // Pastikan setiap penilaian memiliki 'id' dan 'nilai'
                if (isset($penilaian['id']) && isset($penilaian['nilai'])) {
                    // Update nilai penilaian di database
                    BtqPenilaianMahasiswa::where('id', $penilaian['id'])
                        ->update([
                            'nilai' => $penilaian['nilai'], // Nilai (1 atau 0)
                            'penguji_id' => $penguji_id
                        ]);
                } else {
                    // Jika ada data yang tidak valid, kembalikan pesan error
                    return response()->json(['message' => 'Data penilaian tidak lengkap'], 400);
                }
            }

            // Kembalikan respons sukses
            return response()->json(['message' => 'Penilaian berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Jika terjadi error, kirimkan respons error
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan penilaian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selfPenilaian(Request $request)
    {
        try {
            $penilaianData = $request->input('penilaian', []);
            $penguji_id = $request->input('penguji_id'); // Ambil penguji_id

            // Loop melalui semua data penilaian yang dikirimkan
            foreach ($penilaianData as $penilaian) {
                // Pastikan setiap penilaian memiliki 'id' dan 'nilai'
                if (isset($penilaian['id']) && isset($penilaian['nilai_self'])) {
                    // Update nilai penilaian di database
                    BtqPenilaianMahasiswa::where('id', $penilaian['id'])
                        ->update([
                            'nilai_self' => $penilaian['nilai_self'], // Nilai (1 atau 0)
                            'penguji_id' => $penguji_id
                        ]);
                } else {
                    // Jika ada data yang tidak valid, kembalikan pesan error
                    return response()->json(['message' => 'Data penilaian tidak lengkap'], 400);
                }
            }

            // Kembalikan respons sukses
            return response()->json(['message' => 'Penilaian berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Jika terjadi error, kirimkan respons error
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan penilaian',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
