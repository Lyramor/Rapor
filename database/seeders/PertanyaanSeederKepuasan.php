<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Soal;
use App\Models\Pertanyaan;

class PertanyaanSeederKepuasan extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'soal' => 'Informasi dan Kebijakan Fakultas',
                'pertanyaan' => 'Saya merasa mendapat informasi yang cukup tentang kebijakan atau perubahan yang ada di fakultas',
            ],
            [
                'soal' => 'Pengembangan Akademik dan Profesional',
                'pertanyaan' => 'Saya merasa mendapatkan dukungan yang cukup untuk melanjutkan studi atau pendidikan lebih lanjut.',
            ],
            [
                'soal' => 'Pengembangan Akademik dan Profesional',
                'pertanyaan' => 'Pelatihan yang disediakan oleh fakultas membantu meningkatkan kompetensi saya di bidang akademik dan profesional',
            ],
            [
                'soal' => 'Fasilitas dan Sarana Pendukung',
                'pertanyaan' => 'Fasilitas kantor yang disediakan oleh fakultas cukup mendukung kegiatan saya',
            ],
            [
                'soal' => 'Kesejahteraan dan Pendapatan',
                'pertanyaan' => 'Program kesejahteraan yang ada di fakultas memberikan dampak positif bagi kualitas hidup saya',
            ],
            [
                'soal' => 'Fasilitas dan Sarana Pendukung',
                'pertanyaan' => 'Peralatan dan teknologi yang disediakan untuk pengajaran sudah cukup memadai.',
            ],
            [
                'soal' => 'Fasilitas dan Sarana Pendukung',
                'pertanyaan' => 'Sarana pendukung pembelajaran (seperti akses ke laboratorium atau perangkat lunak) tersedia dengan baik',
            ],
            [
                'soal' => 'Kesejahteraan dan Pendapatan',
                'pertanyaan' => 'Saya merasa puas dengan kejelasan sistem penggajian dan tunjangan yang ada di fakultas.',
            ],
            [
                'soal' => 'Kesejahteraan dan Pendapatan',
                'pertanyaan' => 'Proses penggajian dilakukan tepat waktu dan sesuai dengan ketentuan yang berlaku.',
            ],
            [
                'soal' => 'Penugasan dan Kejelasan Tugas',
                'pertanyaan' => 'Saya merasa penugasan yang diberikan sesuai dengan keahlian dan kapasitas saya.',
            ],
            [
                'soal' => 'Penugasan dan Kejelasan Tugas',
                'pertanyaan' => 'Penugasan yang diterima dilakukan secara adil dan tidak diskriminatif.',
            ],
            [
                'soal' => 'Lingkungan Kerja dan Komunikasi',
                'pertanyaan' => 'Lingkungan kerja di fakultas mendukung saya untuk bekerja dengan produktif dan nyaman',
            ],
            [
                'soal' => 'Lingkungan Kerja dan Komunikasi',
                'pertanyaan' => 'Komunikasi antara pegawai dan manajemen SDM berjalan dengan lancar dan terbuka.',
            ],
            [
                'soal' => 'Fasilitas dan Sarana Pendukung',
                'pertanyaan' => 'Fasilitas ruang kelas yang tersedia mendukung proses pengajaran yang efektif.',
            ],
        ];

        foreach ($data as $index => $item) {
            $soal = Soal::firstOrCreate([
                'nama_soal' => $item['soal'],
            ], [
                'id' => Str::uuid(),
                'keterangan' => 'Survei kepuasan pegawai terhadap aspek ' . $item['soal'],
                'soal_acak' => false,
                'publik' => true,
            ]);

            Pertanyaan::create([
                'id' => Str::uuid(),
                'no_pertanyaan' => $index + 1,
                'jenis_pertanyaan' => 'range_nilai',
                'pertanyaan' => $item['pertanyaan'],
                'scale_range_min' => 1,
                'scale_range_max' => 5,
                'scale_text_min' => 'Sangat Tidak Setuju',
                'scale_text_max' => 'Sangat Setuju',
                'soal_id' => $soal->id,
            ]);
        }
    }
}
