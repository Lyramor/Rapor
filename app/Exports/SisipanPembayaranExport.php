<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SisipanPembayaranExport implements FromView, ShouldAutoSize
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        if ($this->data) {
            return view('exports.template-sisipan-pembayaran2', [
                'data' => $this->data
            ]);
        }
        return view('exports.template-sisipan-pembayaran2');
    }
}
