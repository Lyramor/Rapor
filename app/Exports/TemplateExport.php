<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;


class TemplateExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        return view('exports.template');
    }
}
