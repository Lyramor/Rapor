<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RaporExport implements FromView, ShouldAutoSize
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        if ($this->data) {
            return view('exports.template-rapor-kinerja', [
                'data' => $this->data
            ]);
        }
        return view('exports.template-rapor-kinerja');
    }
}
