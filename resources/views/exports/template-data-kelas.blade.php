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
            <th style="text-align: center;vertical-align: middle;">ID</th>
            <th style="text-align: center;vertical-align: middle;">No</th>
            <th style="text-align: center;vertical-align: middle;">Periode</th>
            <th style="text-align: center;vertical-align: middle;">Program Studi</th>
            <th style="text-align: center;vertical-align: middle;">Kode MK</th>
            <th style="text-align: center;vertical-align: middle;">Nama Matakuliah</th>
            <th style="text-align: center;vertical-align: middle;">NIP</th>
            <th style="text-align: center;vertical-align: middle;">Nama Dosen</th>
            <th style="text-align: center;vertical-align: middle;">Jumlah Peserta</th>
            <th style="text-align: center;vertical-align: middle;">Kode Edlink</th>
            <th style="text-align: center;vertical-align: middle;">Catatan</th>
        </tr>

        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $loop->iteration }}</td>
                @if ($item->remedialperiode)
                    <td>{{ $item->remedialperiode->nama_periode }}</td>
                @endif
                @if ($item->sisipanperiode)
                    <td>{{ $item->sisipanperiode->nama_periode }}</td>
                @endif
                <td>{{ $item->programstudi }}</td>
                <td>{{ $item->kodemk }}</td>
                <td>{{ $item->kelaskuliah->namamk }}</td>
                <td>{{ $item->nip }}</td>
                <td>{{ $item->dosen->nama ?? '-' }}</td>
                <td>{{ $item->jumlahpeserta }}</td>
                <td>{{ $item->kode_edlink }}</td>
                <td>{{ $item->catatan }}</td>
            </tr>
        @endforeach

    </table>
</body>

</html>
