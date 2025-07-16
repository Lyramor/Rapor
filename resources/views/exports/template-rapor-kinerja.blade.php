<!-- resources/views/exports/export_header.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table>
        <tr>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">Periode</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">NIP</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">NIDN</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">Prodi</th>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">Nilai BKD</th>
            <th colspan="4" style="text-align: center;vertical-align: middle;">Nilai EDOM</th>
            <th colspan="3" style="text-align: center;vertical-align: middle;">Nilai EDASEB</th>
        </tr>
        <tr>
            <th style="text-align: center;">Materi</th>
            <th style="text-align: center;">Kelas</th>
            <th style="text-align: center;">Pengajaran</th>
            <th style="text-align: center;">Penilaian</th>
            <th style="text-align: center;">Atasan</th>
            <th style="text-align: center;">Sejawat</th>
            <th style="text-align: center;">Bawahan</th>
        </tr>

        @php
            $no = 1;
        @endphp

        @foreach ($data as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->periode_rapor }}</td>
                <td>{{ $row->dosen_nip }}</td>
                <td>{{ $row->dosen->nidn }}</td>
                <td>{{ $row->dosen->nama }}</td>
                <td>{{ $row->programstudi }}</td>
                <td>{{ $row->bkd_total }}</td>
                <td>{{ $row->edom_materipembelajaran }}</td>
                <td>{{ $row->edom_pengelolaankelas }}</td>
                <td>{{ $row->edom_prosespengajaran }}</td>
                <td>{{ $row->edom_penilaian }}</td>
                <td>{{ $row->edasep_atasan }}</td>
                <td>{{ $row->edasep_sejawat }}</td>
                <td>{{ $row->edasep_bawahan }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
