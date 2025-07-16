<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pertanyaan;
use Illuminate\Support\Str;

class PertanyaanSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi tabel kuesioner_pertanyaan.
     */
    public function run(): void
    {
        $pertanyaan_list = [
            // Pertanyaan untuk Bawahan
            'Kejujuran (Bawahan)' => 'Bawahan saya selalu berkomunikasi dengan jujur, baik dalam hal keberhasilan maupun kesulitan, yang membuat saya merasa lebih yakin dalam memberikan arahan.',
            'Loyalitas pada Perusahaan (Bawahan)' => 'Saya merasakan loyalitas yang kuat dari bawahan saya terhadap perusahaan, yang terlihat dalam dedikasi dan upaya mereka setiap hari.',
            'Kerjasama (Bawahan)' => 'Bawahan saya selalu terbuka untuk bekerja sama, saling mendukung dalam setiap tugas, dan berkomitmen terhadap kesuksesan tim.',
            'Kehadiran Tepat Waktu (Bawahan)' => 'Bawahan saya selalu hadir tepat waktu dan berada di meja kerjanya di saat jam kerja serta berusaha menyelesaikan tugasnya secepat mungkin.',
            'Kepemimpinan (Bawahan)' => 'Meskipun saya sebagai atasan, saya merasa bawahan saya mampu menunjukkan kualitas kepemimpinan yang menginspirasi dan memberi contoh positif bagi tim, respek pada jabatan saya sebagai pimpinannya.',
            'Inisiatif/Prakarsa (Bawahan)' => 'Bawahan saya selalu mengambil inisiatif untuk memperbaiki proses dan mencari solusi yang lebih baik tanpa harus menunggu arahan.',
            'Tanggungjawab (Bawahan)' => 'Bawahan saya menunjukkan rasa tanggung jawab yang besar dalam menjalankan tugas dan memastikan bahwa segala sesuatunya berjalan dengan baik.',
            'Ketaatan pada Organisasi (Bawahan)' => 'Bawahan saya selalu mematuhi peraturan yang ada, serta memahami dan menerapkan kebijakan organisasi dengan penuh kesadaran.',
            'Nyunda dan Nyantri (Bawahan)' => 'Bawahan saya selalu menghargai dan mempraktikkan nilai-nilai budaya lokal seperti Nyunda dan Nyantri, yang memperkaya lingkungan kerja kami.',
            'Prestasi Kerja (Bawahan)' => 'Saya merasa bangga dengan prestasi kerja bawahan saya yang terus berkembang, selalu memberikan hasil yang memuaskan dan menginspirasi saya untuk memberikan dukungan lebih.',

            // Pertanyaan untuk Sejawat
            'Kejujuran (Sejawat)' => 'Rekan sejawat saya selalu berbicara dengan jujur dalam setiap situasi, baik saat berhasil maupun ketika menghadapi tantangan.',
            'Loyalitas pada Perusahaan (Sejawat)' => 'Saya merasa rekan sejawat saya memiliki loyalitas yang tinggi terhadap perusahaan, terlihat dari dedikasi dan komitmennya dalam setiap tugas.',
            'Kerjasama (Sejawat)' => 'Rekan sejawat saya selalu terbuka dan mendukung dalam kerjasama tim, membantu satu sama lain untuk mencapai tujuan bersama.',
            'Kehadiran Tepat Waktu (Sejawat)' => 'Rekan sejawat saya selalu datang tepat waktu, yang menunjukkan rasa hormat terhadap pekerjaan dan rekan kerja lainnya.',
            'Kepemimpinan (Sejawat)' => 'Meskipun sebagai rekan, saya merasa rekan sejawat saya memiliki kualitas kepemimpinan yang memotivasi dan memberi contoh yang baik.',
            'Inisiatif/Prakarsa (Sejawat)' => 'Rekan sejawat saya sering mengambil inisiatif untuk memperbaiki keadaan dan menemukan solusi yang lebih baik tanpa menunggu arahan.',
            'Tanggungjawab (Sejawat)' => 'Rekan sejawat saya menunjukkan rasa tanggung jawab yang besar terhadap pekerjaannya dan unit yang dipimpin, memastikan semuanya berjalan dengan baik.',
            'Ketaatan pada Organisasi (Sejawat)' => 'Rekan sejawat saya selalu mematuhi peraturan dan kebijakan organisasi, dan mendorong orang lain untuk melakukan hal yang sama.',
            'Nyunda dan Nyantri (Sejawat)' => 'Rekan sejawat saya selalu menghargai dan mengaplikasikan nilai-nilai budaya lokal seperti Nyunda dan Nyantri di lingkungan kerja.',
            'Prestasi Kerja (Sejawat)' => 'Saya merasa bahwa prestasi kerja rekan sejawat saya luar biasa, selalu memberikan hasil yang membanggakan dan mendorong saya untuk berbuat lebih baik.',
        ];

        foreach ($pertanyaan_list as $soal_nama => $pertanyaan_text) {
            $soal = Soal::where('nama_soal', $soal_nama)->first();

            if ($soal) {
                Pertanyaan::create([
                    'id' => Str::uuid(),
                    'no_pertanyaan' => 1, // Bisa disesuaikan jika ada lebih dari satu pertanyaan per soal
                    'jenis_pertanyaan' => 'range_nilai',
                    'pertanyaan' => $pertanyaan_text,
                    'scale_range_min' => 1,
                    'scale_range_max' => 5,
                    'scale_text_min' => 'Sangat Tidak Setuju',
                    'scale_text_max' => 'Sangat Setuju',
                    'soal_id' => $soal->id,
                ]);
            }
        }
    }
}
