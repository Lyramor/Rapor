<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Models\Pertanyaan;
use App\Models\Soal;

class PertanyaanImport implements ToModel, WithHeadingRow, WithStartRow, RegistersEventListeners
{
    private $soal;

    public function startRow(): int
    {
        return 5; // Data pertanyaan dimulai dari baris ke-5
    }

    public function headingRow(): int
    {
        return 4; // Header pertanyaan berada pada baris ke-4
    }

    public function model(array $row)
    {
        return new Pertanyaan([
            'no_pertanyaan'    => $row['nomor'],
            'jenis_pertanyaan' => $row['jenis_jawaban'],
            'pertanyaan'       => $row['pertanyaan'],
            'scale_range_min'  => $row['nilai_min_khusus_range_nilai'] ?? null,
            'scale_range_max'  => $row['nilai_max_khusus_range_nilai'] ?? null,
            'scale_text_min'   => $row['text_min_khusus_range_nilai'] ?? null,
            'scale_text_max'   => $row['text_max_khusus_range_nilai'] ?? null,
            'soal_id'          => $this->soal->id,
        ]);
    }

    public static function beforeImport(BeforeImport $event)
    {
        $sheet = $event->reader()->getDelegate()->getActiveSheet();

        // Mengambil data dari Excel
        $namaSoal = $sheet->getCell('B1')->getValue();
        $keteranganSoal = $sheet->getCell('B2')->getValue();

        // Membuat atau mencari soal berdasarkan nama dan keterangan
        $soal = Soal::firstOrCreate([
            'nama_soal' => $namaSoal,
            'keterangan' => $keteranganSoal,
        ]);

        // Memperbarui instance saat ini dengan soal yang dibuat atau ditemukan
        $instance = app(static::class);
        $instance->soal = $soal;
    }

    public static function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                static::beforeImport($event);
            },
        ];
    }
}
