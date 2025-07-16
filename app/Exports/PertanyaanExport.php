<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PertanyaanExport implements FromView, ShouldAutoSize
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return View('exports.template-upload-pertanyaan');
    }
}
