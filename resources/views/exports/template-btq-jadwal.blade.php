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
            <th rowspan="1" style="text-align: center;vertical-align: middle;">No</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Periode</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Tempat</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Tanggal</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Waktu Mulai</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Waktu Selesai</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Peserta</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Penguji</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Jumlah Peserta</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Jumlah Peserta Hadir</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Status</th>
        </tr>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->kode_periode }}</td>
                <td>{{ $row->ruang }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->jam_mulai }}</td>
                <td>{{ $row->jam_selesai }}</td>
                <td>{{ $row->peserta }}</td>
                <td>{{ $row->penguji->name }}</td>
                <td>{{ $row->jumlah_peserta }}</td>
                <td>{{ $row->jumlah_peserta_hadir }}</td>
                <td>{{ $row->is_active }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
