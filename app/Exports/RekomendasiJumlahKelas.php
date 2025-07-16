<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Mahasiswa;

class RekomendasiJumlahKelas implements FromView, WithTitle, ShouldAutoSize
{

    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Daftar Rekomendasi Jumlah Kelas'; // Nama untuk sheet pertama
    }

    public function view(): View
    {
        // $mahasiswa = Mahasiswa::with('unitKerja')->get();

        // return view('exports.template-daftar-mahasiswa-non-aktif', [
        //     'mahasiswa' => $mahasiswa
        // ]);
        if ($this->data) {
            return view('exports.template-rekomendasi-jumlah', [
                'data' => $this->data
            ]);
        }
        return view('exports.template-rekomendasi-jumlah');
    }
}
