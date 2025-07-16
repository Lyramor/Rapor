<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DataKelasExport implements FromView, ShouldAutoSize, WithColumnFormatting, WithEvents
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
            'D' => NumberFormat::FORMAT_NUMBER, // Mengatur kolom D menjadi number
            'G' => NumberFormat::FORMAT_TEXT, // Mengatur kolom G menjadi number
        ];
    }

    public function view(): View
    {
        return view('exports.template-data-kelas', [
            'data' => $this->data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menyembunyikan kolom A
                $event->sheet->getDelegate()->getColumnDimension('A')->setVisible(false);
            },
        ];
    }
}
