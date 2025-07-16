{{-- @extends('pdf.template-pdf') --}}

{{-- @section('content') --}}
<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <style>
        /* Gaya CSS Anda bisa dimasukkan di sini */
        .content {
            /* background-color: aqua; */
            margin: 80px 30px 60px 30px;
        }

        h1,
        h2,
        h3,
        h4 {
            text-align: center;
            line-height: 0.5;
        }

        .table-rapor {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            line-height: 0.7;
        }

        .table-rapor th {
            border: 1px solid black;
            text-align: center;
            padding: 10px auto;
        }

        .table-rapor td {
            border: 1px solid black;
            padding: 8px;
        }

        .kolom-nomor {
            width: 10px;
        }

        .kolom-tengah {
            text-align: center;
            padding: 3px auto;
            width: 150px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            /* Sesuaikan tinggi header Anda */
            /* background-color: #f2f2f2; */
            text-align: center;
        }

        footer {
            position: fixed;
            z-index: 99999;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            /* Sesuaikan tinggi footer Anda */
            /* background-color: #f2f2f2; */
            text-align: center;
        }

        .tengah {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    @foreach ($dataRapor as $rapor)
        <div class="container" style="max-height: 1200px;">
            <div style="width: 100%;height:80px; background-color: bisque">
                <header>
                    <img src="{{ public_path('storage/images/Kop-FT.PNG') }}" style="width: 100%" alt="Logo"
                        class="logo">
                </header>
            </div>
            <div class="header-judul">
                <h1 style="margin-top: 40px">{{ $title }}</h1>
                <h3>{{ $subtitle }}</h3>
            </div>
            <table>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $rapor->dosen_nip }}</td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td>{{ $rapor->dosen->nama }}</td>
                </tr>
                <tr>
                    <td>PRODI</td>
                    <td>:</td>
                    <td>{{ $rapor->programstudi }}</td>
                </tr>
            </table>
            <table class="table-rapor">
                <th colspan="2">Indikator Kinerja</th>
                <th>Target</th>
                <th>Fakta</th>
                <th>Nilai</th>
                <th>Bobot(%)</th>
                <th>Nilai Per Indikator</th>
                <tr>
                    <td colspan="5">a. Unsur BKD Sister</td>
                    <td class="kolom-tengah" rowspan="6">50</td>
                    <td class="kolom-tengah" rowspan="6">{{ number_format($rapor->nilai_bkd, 2) }}</td>
                </tr>
                <tr>
                    <td class="kolom-nomor">1.</td>
                    <td>Pendidikan</td>
                    <td class="tengah" rowspan="5">12.00</td>
                    <td class="tengah" rowspan="5">{{ $rapor->bkd_total }}</td>
                    <td class="tengah" rowspan="5">
                        {{ number_format($rapor->bkd_total >= 12 ? 100 : ($rapor->bkd_total / 12) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Penelitian</td>
                    {{-- <td style="text-align: center">M</td>
                    <td style="text-align: center">{{ $rapor->bkd_penelitian }}</td>
                    <td style="text-align: center">
                        {{ $rapor->bkd_penelitian == 'M' ? '100' : '0' }}
                    </td> --}}
                </tr>
                <tr>
                    <td>3.</td>
                    <td>PPM</td>
                    {{-- <td style="text-align: center">M</td>
                    <td style="text-align: center">{{ $rapor->bkd_ppm }}</td>
                    <td style="text-align: center">
                        {{ $rapor->bkd_ppm == 'M' ? '100' : '0' }}
                    </td> --}}
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Penunjang</td>
                    {{-- <td style="text-align: center">M</td>
                    <td style="text-align: center">{{ $rapor->bkd_penunjangan }}</td>
                    <td style="text-align: center">
                        {{ $rapor->bkd_penunjangan == 'M' ? '100' : '0' }}
                    </td> --}}
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Kewajiban Khusus</td>
                    {{-- <td style="text-align: center">M</td>
                    <td style="text-align: center">{{ $rapor->bkd_kewajibankhusus }}</td>
                    <td style="text-align: center">
                        {{ $rapor->bkd_kewajibankhusus == 'M' ? '100' : '0' }}
                    </td> --}}
                </tr>
                <tr>
                    <td colspan="5">b. EDOM</td>
                    <td rowspan="5" class="kolom-tengah">25</td>
                    <td rowspan="5" class="kolom-tengah">{{ number_format($rapor->nilai_edom, 2) }}</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Materi Pembelajaran</td>
                    <td style="text-align: center">3.00</td>
                    <td style="text-align: center">{{ $rapor->edom_materipembelajaran }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edom_materipembelajaran >= 3.0 ? 100 : ($rapor->edom_materipembelajaran / 3.0) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Pengelolaan Kelas</td>
                    <td style="text-align: center">3.00</td>
                    <td style="text-align: center">{{ $rapor->edom_pengelolaankelas }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edom_pengelolaankelas >= 3.0 ? 100 : ($rapor->edom_pengelolaankelas / 3.0) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Proses Pengajaran</td>
                    <td style="text-align: center">3.00</td>
                    <td style="text-align: center">{{ $rapor->edom_prosespengajaran }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edom_prosespengajaran >= 3.0 ? 100 : ($rapor->edom_prosespengajaran / 3.0) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Penilaian</td>
                    <td style="text-align: center">3.00</td>
                    <td style="text-align: center">{{ $rapor->edom_penilaian }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edom_penilaian >= 3.0 ? 100 : ($rapor->edom_penilaian / 3.0) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5">c. EDASEP</td>
                    <td rowspan="3" class="kolom-tengah">25</td>
                    <td rowspan="3" class="kolom-tengah">{{ number_format($rapor->nilai_edasep, 2) }}</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Atasan</td>
                    <td style="text-align: center">90</td>
                    <td style="text-align: center">{{ $rapor->edasep_atasan }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edasep_atasan >= 90 ? 100 : ($rapor->edasep_atasan / 90) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Sejawat</td>
                    <td style="text-align: center">90</td>
                    <td style="text-align: center">{{ $rapor->edasep_sejawat }}</td>
                    <td style="text-align: center">
                        {{ number_format($rapor->edasep_sejawat >= 90 ? 100 : ($rapor->edasep_sejawat / 90) * 100, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 0px solid #dddddd"></td>
                    <td colspan="3">TOTAL NILAI</td>
                    <td colspan="2" style="text-align: center">{{ number_format($rapor->nilai_total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">GRADE</td>
                    <td colspan="2" style="text-align: center">{{ $rapor->grade }}</td>
                </tr>
            </table>
            <div class="ttd-bawah" style="text-align:right;margin-top:5px">
                <p style="padding-right: 50;">Bandung,
                    {{ $tanggal }}</p><img src="{{ public_path('storage/images/ttd-pa-yusman.PNG') }}"
                    alt="Logo" style="width: 40%;padding-right:60px">
            </div>
        </div>
        <footer>
            {{-- <p>Ini adalah footer</p> --}}
            <img src="{{ public_path('storage/images/footer-ft.PNG') }}" style="width: 100%" alt="Logo"
                class="logo">
        </footer>
    @endforeach
</body>
