<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TemplateUploadKuesionerSDM implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    public function title(): string
    {
        return 'Form Kuesioner SDM'; // Nama untuk sheet pertama
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Kolom F menjadi tipe tanggal (format DD/MM/YYYY)
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Kolom G menjadi tipe tanggal (format DD/MM/YYYY)
        ];
    }

    public function view(): View
    {
        return view('exports.template-upload-kuesionersdm');
    }
}
