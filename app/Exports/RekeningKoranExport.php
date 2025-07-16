<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekeningKoranExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT, // Mengatur kolom C menjadi teks
            // D dan E menjadi number
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function view(): View
    {
        return View('exports.template-rekening-koran');
    }
}
