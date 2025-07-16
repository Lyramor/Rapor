<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kuesioner SDM</title>
    <style>
         @page {
            margin: 40px 0px 20px 0px;
        }

        body {
            margin-top: 2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 0.2cm;
            font-family: Calibri, sans-serif;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /* Ubah tinggi header sesuai kebutuhan */
            margin-left: 50px;
            margin-right: 50px;
            margin-top: 20px;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            /* Ubah tinggi footer sesuai kebutuhan */
            text-align: center;
            line-height: 1cm;
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 30px;
        }

        .wrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 20px;
        }
    
        h2, h3 {
            text-align: center;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('storage/images/Kop-FT.PNG') }}" style="width: 100%;" alt="Logo" class="logo">
    </header>

    <footer>
        <img src="{{ public_path('storage/images/footer-ft.PNG') }}" style="width: 80%;" alt="Logo" class="logo">
    </footer>

    @foreach($result as $data)
    <h2>Laporan Rekap Kuesioner</h2>
    <h3>Periode: {{ $result->first()['periode'] ?? '-' }}</h3>
        <div class="pegawai-block">
            <table>
                
                @if($data['nama'] == $data['unit'])
                    <tr>
                        <th style="width: 20%">Kode Unit Kerja</th>
                        <td>{{ $data['nip'] }}</td>
                    </tr>

                    <tr>
                        <th>Unit Kerja</th>
                        <td>{{ $data['unit'] }}</td>
                    </tr>
                @else
                    <tr>
                        <th style="width: 20%">NIP</th>
                        <td>{{ $data['nip'] }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pegawai</th>
                        <td>{{ $data['nama'] }}</td>
                        </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td>{{ $data['unit'] }}</td>
                    </tr>
                @endif

                <tr>
                    <th>Periode</th>
                    <td>{{ $data['periode'] }}</td>
                </tr>
            </table>

            @if($data['nama'] == $data['unit'])
                <h4 style="margin-top: 10px;">Rekapitulasi Unsur Penilaian Pimpinan</h4>
            @else
                 <h4 style="margin-top: 10px;">Rekapitulasi Unsur Penilaian DP3</h4>
            @endif

            <div class="table-container" style="width: 100%;">
                <!-- <div class="table-container" style="width: 40%;float: left;"> -->
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Unsur Penilaian</th>
                                <th style="width: 15%;">Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($data['unsur'] as $unsur)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $unsur['nama'] }}</td>
                                    <td style="text-align: center;">{{ number_format($unsur['rata_rata'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- <div class="chart-container" style="width: 40%;">
                        @if (!empty($data['chart']))
                            <img src="{{ $data['chart'] }}" alt="Radar Chart" width="300">
                        @else
                            <p>Grafik tidak tersedia.</p>
                        @endif
            </div> -->
        <div class="page-break"></div>
    @endforeach

</body>
</html>