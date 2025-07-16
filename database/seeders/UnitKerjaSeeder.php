<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {
        // Universitas Pasundan
        $universitas_pasundan_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $universitas_pasundan_id,
            'kode_unit' => 'UNP',
            'nama_unit' => 'Universitas Pasundan',
            'nama_unit_en' => 'Pasundan University',
            'nama_singkat' => 'Unpas',
            'jenis_unit' => 'Perguruan Tinggi',
            'tk_pendidikan' => 'Perguruan Tinggi',
            'alamat' => 'Jl. Setiabudhi No.193, Bandung',
            'telepon' => '(022) 2013163',
            'website' => 'https://www.unpas.ac.id/',
            'alamat_email' => 'info@unpas.ac.id',
            'akreditasi' => 'A',
            'no_sk_akreditasi' => '123/SK/BAN-PT/Akred/PT/V/2018',
            'tanggal_akreditasi' => '2018-05-20',
            'no_sk_pendirian' => '456/SK/BAN-PT/Akred/PT/V/2010',
            'tanggal_sk_pendirian' => '2010-09-10',
            'gedung' => 'Gedung Rektorat Lt. 3',
            'akademik' => 'Universitas',
            'status_aktif' => true,
            'parent_unit' => null,
        ]);

        // Fakultas Teknik
        $fakultas_teknik_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $fakultas_teknik_id,
            'kode_unit' => 'FT',
            'nama_unit' => 'Fakultas Teknik',
            'nama_unit_en' => 'Faculty of Engineering',
            'nama_singkat' => 'FT',
            'jenis_unit' => 'Fakultas',
            'tk_pendidikan' => 'Perguruan Tinggi',
            'alamat' => 'Jl. Cimuncang No. 43, Bandung',
            'telepon' => '(022) 5551234',
            'website' => 'https://ft.unpas.ac.id/',
            'alamat_email' => 'info@ft.unpas.ac.id',
            'akreditasi' => 'A',
            'no_sk_akreditasi' => '789/SK/BAN-PT/Akred/FT/V/2015',
            'tanggal_akreditasi' => '2015-10-15',
            'no_sk_pendirian' => '101/SK/BAN-PT/FT/V/2002',
            'tanggal_sk_pendirian' => '2002-12-05',
            'gedung' => 'Gedung Dekanat Lt. 2',
            'akademik' => 'Fakultas',
            'status_aktif' => true,
            'parent_unit' => $universitas_pasundan_id,
        ]);

        // Fakultas Hukum
        $fakultas_hukum_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $fakultas_hukum_id,
            'kode_unit' => 'FH',
            'nama_unit' => 'Fakultas Hukum',
            'nama_unit_en' => 'Faculty of Law',
            'nama_singkat' => 'FH',
            'jenis_unit' => 'Fakultas',
            'tk_pendidikan' => 'Perguruan Tinggi',
            'alamat' => 'Jl. Dipatiukur No. 35, Bandung',
            'telepon' => '(022) 7775678',
            'website' => 'https://fh.unpas.ac.id/',
            'alamat_email' => 'info@fh.unpas.ac.id',
            'akreditasi' => 'A',
            'no_sk_akreditasi' => '246/SK/BAN-PT/Akred/FH/V/2016',
            'tanggal_akreditasi' => '2016-07-30',
            'no_sk_pendirian' => '303/SK/BAN-PT/FH/V/2004',
            'tanggal_sk_pendirian' => '2004-11-20',
            'gedung' => 'Gedung FH Lt. 1',
            'akademik' => 'Fakultas',
            'status_aktif' => true,
            'parent_unit' => $universitas_pasundan_id,
        ]);

        // Unit Kerja di Fakultas Teknik
        $unit_kerja_teknik_mesin_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_teknik_mesin_id,
            'kode_unit' => 'UTM',
            'nama_unit' => 'Teknik Mesin',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_teknik_id,
        ]);

        $unit_kerja_teknik_lingkungan_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_teknik_lingkungan_id,
            'kode_unit' => 'UTL',
            'nama_unit' => 'Teknik Lingkungan',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_teknik_id,
        ]);

        $unit_kerja_teknik_industri_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_teknik_industri_id,
            'kode_unit' => 'UTI',
            'nama_unit' => 'Teknik Industri',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_teknik_id,
        ]);

        $unit_kerja_perencanaan_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_perencanaan_id,
            'kode_unit' => 'UPLWK',
            'nama_unit' => 'Perencanaan Wilayah dan Kota',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_teknik_id,
        ]);

        $unit_kerja_informatika_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_informatika_id,
            'kode_unit' => 'UTIF',
            'nama_unit' => 'Teknik Informatika',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_teknik_id,
        ]);

        // Unit Kerja di Fakultas Hukum
        $unit_kerja_ilmu_hukum_id = Str::uuid();
        DB::table('unit_kerja')->insert([
            'id' => $unit_kerja_ilmu_hukum_id,
            'kode_unit' => 'UHI',
            'nama_unit' => 'Ilmu Hukum',
            'jenis_unit' => 'Program Studi',
            'tk_pendidikan' => 'Sarjana',
            'status_aktif' => true,
            'parent_unit' => $fakultas_hukum_id,
        ]);
    }
}
