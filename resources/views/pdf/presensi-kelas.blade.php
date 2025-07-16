<!DOCTYPE html>
<html lang="en">

<head>
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

        .table-pbp {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }

        .table-pbp th {
            /* background-color: orange; */
        }

        .table-pbp tr {
            height: 100px;
            /* Sesuaikan tinggi sesuai kebutuhan */
        }

        .table-pbp td {
            font-size: 9px;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .table-pbp th {
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .table-pbp thead {
            display: table-header-group;
        }

        .table-pbp tbody {
            display: table-row-group;
        }

        .ttd {
            vertical-align: bottom;
            /* Menyelaraskan konten ke bawah */
            padding-bottom: 5px;

            /* Atur sesuai kebutuhan untuk mendekatkan ke garis bawah */
        }

        .ttd td {
            height: 70px;
        }

        .ttd div {
            margin-bottom: 0px;
            /* Contoh menggunakan margin negatif, sesuaikan nilai sesuai kebutuhan */
        }

        .signature-cell {
            height: 42px;
            /* Sesuaikan tinggi sesuai kebutuhan */
        }

        .pagenum:before {
            content: counter(page);
        }

        .totalpages:before {
            content: attr(data-totalpages);
        }

        .last-page header {
            display: none;
            /* Hide header on last page */
        }

        .judul-konten p:last-child {
            margin-top: 5px;
            text-align: justify;
        }
    </style>
</head>

<body>
    <header>
        @if ($kelas->programstudi == 'Ilmu Hukum')
            <img src="{{ public_path('storage/images/Kop-FH.jpg') }}" style="width: 100%;" alt="Logo" class="logo">
        @else
            <img src="{{ public_path('storage/images/Kop-FT.PNG') }}" style="width: 100%;" alt="Logo" class="logo">
        @endif
    </header>

    <footer>
        @if ($kelas->programstudi == 'Ilmu Hukum')
            <img src="{{ public_path('storage/images/footer-fh.PNG') }}" class="mb-10" style="width: 100%;"
                alt="Logo" class="logo">
        @else
            <img src="{{ public_path('storage/images/footer-ft.PNG') }}" style="width: 80%;" alt="Logo"
                class="logo">
        @endif
        {{-- <p>Ini adalah footer</p> --}}
    </footer>

    <main>
        <div class="content">
            <section class="main-content" style="margin-top:0px">
                <section class="judul-konten">
                    <h4 style="text-align: center;margin-top:10px;">DAFTAR HADIR<br>
                    </h4>
                    <p style="text-align: center;margin-top:-20px">
                        @if ($kelas->sisipanperiode)
                            {{ $kelas->sisipanperiode->nama_periode }}
                        @endif

                        @if ($kelas->remedialperiode)
                            {{ $kelas->remedialperiode->nama_periode }}
                        @endif
                    </p>
                </section>
                <table>
                    <tr>
                        <td>Kode MK / Matakuliah</td>
                        <td>:</td>
                        <td>{{ $kelas->kodemk }} / {{ $kelas->kelaskuliah->namamk }}</td>
                    </tr>
                    <tr>
                        <td>
                            Dosen Pengampu
                        </td>
                        <td>:</td>
                        <td>{{ $kelas->dosen->nip }} / {{ $kelas->dosen->nama }}</td>
                    </tr>
                </table>

                <br>
                <table class="table-pbp">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">NIM </th>
                            <th rowspan="2">Nama</th>
                            <th colspan="7">Pertemuan *</th>
                            <th colspan="2">Nilai Lama</th>
                            <th colspan="2">Nilai Baru</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>Angka</th>
                            <th>Huruf</th>
                            <th>Angka</th>
                            <th>Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $mahasiswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mahasiswa->mhs_nim }}</td>
                                <td>{{ $mahasiswa->mhs_nama }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $mahasiswa->old_nnumerik ?? '-' }}</td>
                                <td>{{ $mahasiswa->old_nhuruf ?? '-' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="font-size: 11px;margin-top:5px; margin-bottom: 10px"><sup>*</sup> Mahasiswa memberikan paraf
                    pada pertemuan
                    yang dilaksanakan</p>
                <div style="page-break-before: always;"></div>
                <br>
                <section class="judul-konten">
                    <h4 style="text-align: center;margin-top:10px;">LEMBAR BERITA ACARA PERKULIAHAN<br>
                    </h4>

                    <p style="text-align: center;margin-top:-20px">
                        @if ($kelas->sisipanperiode)
                            {{ $kelas->sisipanperiode->nama_periode }}
                        @endif

                        @if ($kelas->remedialperiode)
                            {{ $kelas->remedialperiode->nama_periode }}
                        @endif
                    </p>
                </section>
                <table>
                    <tr>
                        <td>Kode MK / Matakuliah</td>
                        <td>:</td>
                        <td>{{ $kelas->kodemk }} / {{ $kelas->kelaskuliah->namamk }}</td>
                    </tr>
                    <tr>
                        <td>
                            Dosen Pengampu
                        </td>
                        <td>:</td>
                        <td>{{ $kelas->dosen->nip }} / {{ $kelas->dosen->nama }}</td>
                    </tr>
                </table>
                <br>
                <table class="table-pbp">
                    <thead>
                        <tr>
                            <th style="width: 20%">Pertemuan Ke-</th>
                            <th style="width: 20%">Tanggal </th>
                            <th style="width: 60%">Berita Acara Perkuliahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- for 7 kali --}}
                        @for ($i = 1; $i <= 7; $i++)
                            <tr>
                                <td style="height:80px"></td>
                                <td style="height:80px"></td>
                                <td style="height:80px"></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <div style="page-break-before: always;"></div>
                <br>

                <section class="judul-konten">
                    <h4 style="text-align: center;margin-top:10px;">LEMBAR PENGESAHAN<br>
                    </h4>
                    <p style="text-align: center;margin-top:-20px">
                        @if ($kelas->sisipanperiode)
                            {{ $kelas->sisipanperiode->nama_periode }}
                        @endif

                        @if ($kelas->remedialperiode)
                            {{ $kelas->remedialperiode->nama_periode }}
                        @endif
                    </p>
                </section>
                <p style="float: right;margin-top:0px;margin-right: 60px">............. , .........................
                    2024</p>
                <div style="clear: both"></div>
                <table style="text-align:center;">
                    <tr>
                        <td style="width: 353px;">
                            Mengetahui
                            <br>
                            <strong>Pimpinan Program Studi* <br>
                                {{ $kelas->programstudi }}</strong>
                        </td>
                        <td style="width: 353px">
                            Yang menyerahkan
                            <br>
                            <strong>Dosen Pengampu</strong>
                        </td>
                    </tr>
                    <tr class="ttd">
                        <td>
                            <div style="color: rgb(209, 209, 209)">
                                (Tanda Tangan dan Stempel)
                            </div>
                        </td>
                        <td>
                            <div style="color: rgb(209, 209, 209)">
                                (Tanda Tangan)
                            </div>
                        </td>
                    </tr>
                    <tr class="ttd">
                        <td>
                            <div>................................. <br>
                                (Nama Jelas)
                            </div>
                        </td>
                        <td>
                            <div>................................. <br>
                                (Nama Jelas)
                            </div>
                        </td>
                    </tr>
                </table>
                <p id="page-info"></p> <!-- Paragraf untuk menampilkan informasi halaman -->
                <p>Keterangan : <br>
                    * Bisa diwakilkan oleh Sekretaris Program Studi.
                </p>
            </section>
        </div>
    </main>
</body>

</html>
