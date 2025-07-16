<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Pegawai;

class DaftarPegawai implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    public function title(): string
    {
        return 'Daftar Pegawai'; // Nama untuk sheet pertama
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Mengatur kolom B menjadi teks
        ];
    }

    public function view(): View
    {
        $pegawai = Pegawai::with('unitKerja')->get();

        return view('exports.template-daftar-pegawai', [
            'pegawai' => $pegawai
        ]);
    }
}
