<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Mahasiswa;

class DaftarMahasiswaNonAktif implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
{

    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Daftar Mahasiswa Non Aktif'; // Nama untuk sheet pertama
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Mengatur kolom B menjadi teks
        ];
    }

    public function view(): View
    {
        // $mahasiswa = Mahasiswa::with('unitKerja')->get();

        // return view('exports.template-daftar-mahasiswa-non-aktif', [
        //     'mahasiswa' => $mahasiswa
        // ]);
        if ($this->data) {
            return view('exports.template-daftar-mahasiswa-non-aktif', [
                'data' => $this->data
            ]);
        }
        return view('exports.template-daftar-mahasiswa-non-aktif');
    }
}
