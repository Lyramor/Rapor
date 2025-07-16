<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// class KuesionerExport implements FromView, ShouldAutoSize
// {
//     protected $data;

//     public function __construct($data = null)
//     {
//         $this->data = $data;
//     }

//     public function view(): View
//     {
//         return View('exports.template-upload-kuesionersdm');
//     }
// }

class KuesionerSDMExport implements ShouldAutoSize, WithMultipleSheets
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new TemplateUploadKuesionerSDM(), // Sheet pertama untuk form kosong
            new DaftarPegawai(), // Sheet kedua untuk data pegawai
        ];
    }
}
