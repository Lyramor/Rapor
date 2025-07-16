<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BtqPenilaian;

class BtqPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel btq_penilaian
        $data = [
            // Tulisan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf hijaiyah dengan benar dan jelas',
                'text_penilaian_self' => 'Saya bisa menulis huruf hijaiyah dengan benar dan jelas tanpa kesalahan.',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta dapat membedakan dan menulis huruf yang mirip (contoh: ba, ta, tsa)',
                'text_penilaian_self' => 'Saya bisa membedakan dan menulis huruf yang mirip tanpa kesalahan (contoh: ba, ta, tsa).',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda baca (fathah, kasrah, dhammah) dengan benar',
                'text_penilaian_self' => 'Saya menulis tanda baca (fathah, kasrah, dhammah) dengan benar pada tempatnya.',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda panjang (mad) dengan benar (contoh: مَٰلِكِ)',
                'text_penilaian_self' => 'Saya menulis tanda panjang (mad) dengan benar sesuai kaidah.',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf bersyaddah dengan benar (contoh: رَبِّ)',
                'text_penilaian_self' => 'Saya menulis huruf bersyaddah dengan benar dan sesuai kaidah.',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda tanwin dan sukun dengan benar',
                'text_penilaian_self' => 'Saya menulis tanda tanwin dan sukun dengan benar pada tempat yang sesuai.',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf yang didiktekan dengan benar (2/4)',
                'text_penilaian_self' => 'Saya bisa menulis huruf / kata alquran yang didiktekan dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda baca yang didiktekan dengan benar (fathah, kasrah, dhammah) (2/4)',
                'text_penilaian_self' => 'Saya bisa menulis huruf / kata alquran dengan tanda baca (fathah, kasrah, dhammah) yang didiktekan dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf bersambung yang didiktekan dengan benar (2/4)',
                'text_penilaian_self' => 'Saya bisa menulis huruf / kata alquran bersambung yang didiktekan dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda panjang (mad) yang didiktekan dengan tepat (2/4)',
                'text_penilaian_self' => 'Saya bisa menulis huruf / kata alquran dengan tanda panjang (mad) yang didiktekan dengan benar.',
                'is_active' => true,
            ],

            // Hafalan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'An-Nas',
                'text_penilaian_self' => 'Saya bisa menghafal surah An-Nas dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Falaq',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Falaq dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Ikhlas',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Ikhlas dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Lahab',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Lahab dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'An-Nasr',
                'text_penilaian_self' => 'Saya bisa menghafal surah An-Nasr dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Kafirun',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Kafirun dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Kawthar',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Kawthar dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Ma\'un',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Ma\'un dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Quraisy',
                'text_penilaian_self' => 'Saya bisa menghafal surah Quraisy dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Fil',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Fil dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 11,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Humazah',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Humazah dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 12,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Asr',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Asr dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 13,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'At-Takathur',
                'text_penilaian_self' => 'Saya bisa menghafal surah At-Takathur dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 14,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Qari\'ah',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Qari\'ah dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 15,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Adiyat',
                'text_penilaian_self' => 'Saya bisa menghafal surah Al-Adiyat dengan benar dan lancar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 16,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Juz 30',
                'text_penilaian_self' => 'Saya sudah hafal seluruh Juz 30 dengan lancar dan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 17,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 2 Juz',
                'text_penilaian_self' => 'Saya sudah hafal lebih dari 2 Juz dengan lancar dan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 18,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 5 Juz',
                'text_penilaian_self' => 'Saya sudah hafal lebih dari 5 Juz dengan lancar dan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 19,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 10 Juz',
                'text_penilaian_self' => 'Saya sudah hafal lebih dari 10 Juz dengan lancar dan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 20,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal 30 Juz',
                'text_penilaian_self' => 'Saya sudah hafal seluruh Al-Qur\'an (30 Juz) dengan lancar dan benar.',
                'is_active' => true,
            ],

            // Bacaan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta mengenal huruf hijaiyah dengan benar',
                'text_penilaian_self' => 'Saya bisa mengenal dan membaca huruf hijaiyah dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca tanda baca dasar (fathah, kasrah, dhammah) dengan benar',
                'text_penilaian_self' => 'Saya bisa membaca tanda baca dasar (fathah, kasrah, dhammah) dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf bersambung dengan benar (contoh: كٓهيعٓصٓ pada ayat 1)',
                'text_penilaian_self' => 'Saya bisa membaca huruf bersambung dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf sukun dengan benar',
                'text_penilaian_self' => 'Saya bisa membaca huruf sukun dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf bersyaddah dengan benar (contoh: رَبُّكَ pada ayat 2)',
                'text_penilaian_self' => 'Saya bisa membaca huruf bersyaddah dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca dengan intonasi dan artikulasi yang baik',
                'text_penilaian_self' => 'Saya membaca dengan intonasi dan artikulasi yang baik.',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca ayat pendek tanpa terhenti (ayat 1-3)',
                'text_penilaian_self' => 'Saya bisa membaca ayat pendek tanpa terhenti atau salah.',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca ayat yang lebih panjang tanpa kesalahan (ayat 4)',
                'text_penilaian_self' => 'Saya bisa membaca ayat panjang tanpa kesalahan.',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca dengan irama yang baik dan teratur',
                'text_penilaian_self' => 'Saya membaca dengan irama yang baik dan teratur.',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menyelesaikan bacaan tanpa kesalahan berarti sepanjang ayat 1-10',
                'text_penilaian_self' => 'Saya menyelesaikan bacaan tanpa kesalahan berarti.',
                'is_active' => true,
            ],
            [
                'no_urut' => 11,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Membaca ayat dengan jeda yang tepat sesuai kaidah waqaf (berhenti)',
                'text_penilaian_self' => 'Saya berhenti sesuai kaidah waqaf tanpa memutus makna ayat.',
                'is_active' => true,
            ],
            [
                'no_urut' => 12,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum izhar dengan benar',
                'text_penilaian_self' => 'Saya menerapkan hukum izhar dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 13,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum ikhfa dengan tepat',
                'text_penilaian_self' => 'Saya menerapkan hukum ikhfa dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 14,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum idgham dengan benar',
                'text_penilaian_self' => 'Saya menerapkan hukum idgham dengan benar.',
                'is_active' => true,
            ],
            [
                'no_urut' => 15,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum iqlab dengan benar',
                'text_penilaian_self' => 'Saya menerapkan hukum iqlab dengan benar.',
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            BtqPenilaian::create([
                'no_urut' => $item['no_urut'],
                'jenis_penilaian' => $item['jenis_penilaian'],
                'text_penilaian' => $item['text_penilaian'],
                'text_penilaian_self' => $item['text_penilaian_self'],
                'is_active' => $item['is_active'],
            ]);
        }
    }
}
