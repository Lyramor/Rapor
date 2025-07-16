<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\BtqJadwal;
use App\Models\BtqJadwalMahasiswa;
use App\Models\RoleUser;

class BtqController extends Controller
{
    public function index()
    {
        if (session('selected_role') == 'Pementor') {
            return $this->indexPenguji();
        } else if (session('selected_role') == 'Admin') {
            return $this->indexAdmin();
        } else if (session('selected_role') == 'Mahasiswa') {
            // return "Mahasiswa";
            return $this->indexMahasiswa();
        } else {
            return redirect()->route('home');
        }
    }

    // index-penguji
    public function indexPenguji()
    {
        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('penguji_id', auth()->user()->username)
            ->where('is_active', "!=", "Selesai")
            // ->orderBy('tanggal', 'asc')
            ->orderBy('is_active', 'asc')
            ->get();

        return view('btq.index-penguji', [
            'jadwal' => $jadwal
        ]);
    }

    // riwayatJadwal
    public function riwayatJadwal()
    {
        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('penguji_id', auth()->user()->username)
            ->where('is_active', "Selesai")
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('btq.index-penguji', [
            'jadwal' => $jadwal
        ]);
    }

    // index-peserta
    public function indexMahasiswa()
    {
        $user = auth()->user();

        // Cek apakah jeniskelamin di mahasiswa null
        $showModal = false; // Default, modal tidak ditampilkan

        if ($user->mahasiswa && is_null($user->mahasiswa->jeniskelamin)) {
            $showModal = true; // Tampilkan modal jika jeniskelamin null
        }


        $jadwal = BtqJadwalMahasiswa::with(['jadwal', 'mahasiswa'])
            ->where('mahasiswa_id', auth()->user()->username)
            ->get();

        return view('btq.index-mahasiswa', [
            'jadwal' => $jadwal,
            'showModal' => $showModal
        ]);
    }

    // indexAdmin
    public function indexAdmin()
    {   
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
        $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

        $pementor = RoleUser::where('role_id','9d3d80b0-8700-4411-b971-2d9426f62f71')
                    ->whereIn('unit_kerja_id', $unitKerjaIds)
                    ->get();

        $countPementor = $pementor->count();
        
        // jumlahpeserta mahasiswa yang terdaftar btq
        $jadwal_mahasiswa = BtqJadwalMahasiswa::with(['jadwal', 'mahasiswa'])
            ->whereHas('jadwal', function($query){
                $query->where('kode_periode', '20241');
            })
            ->get();
        
        $countPeserta = $jadwal_mahasiswa->count();

        $jadwal_aktif = BtqJadwal::where('is_active', 'Aktif')->where('kode_periode', '20241')->get();
        $countJadwalAktif = $jadwal_aktif->count();

        $jadwal_selesai = BtqJadwal::with('penguji')->where('is_active', 'Selesai')->where('kode_periode', '20241')->get();
        $countJadwalSelesai = $jadwal_selesai->count();

        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('is_active', "!=", "Selesai")
            ->orderBy('tanggal', 'asc')
            ->get();

        // $rekap = BtqJadwal::select('penguji_id')
        //     ->with('penguji')
        //     ->groupBy('penguji_id')
        //     ->get();

        // $rekap = BtqJadwal::with('penguji') // Mengambil data pementor
        //         ->withCount('mahasiswaTerdaftar') // Menghitung total mahasiswa terdaftar
        //         ->withCount(['mahasiswaTerdaftar as jumlah_peserta_hadir' => function ($query) {
        //             $query->where('presensi', true); // Hanya hitung yang hadir
        //         }])
        //         ->groupBy('penguji_id')
        //         ->selectRaw('COUNT(id) as jumlah_jadwal, penguji_id')
        //         ->get();

        // echo $jadwal_selesai;

        return view('btq.index-admin', [
            'jadwal' => $jadwal,
            'unitKerja' => $unitKerja,
            'countPementor' => $countPementor,  
            'countPeserta' => $countPeserta,
            'countJadwalAktif' => $countJadwalAktif,
            'countJadwalSelesai' => $countJadwalSelesai
        ]);

        // no, periode, tanggal, ruang, jam mulai , jam selesai, jumlahpeserta yang presensinya hadir
    }
}
