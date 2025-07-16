<!-- resources/views/exports/export_header.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table style="text-align: center">
        <tr>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nomor</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>NIP/NIDN</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Unit Kerja</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jenis Pegawai</strong></td>
        </tr>

        @foreach ($pegawai as $item)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $item->nip }}
                </td>
                <td>
                    {{ $item->nama }}
                </td>
                <td>
                    {{ $item->unitKerja->nama_unit }}
                </td>
                <td>
                    {{ $item->jenispegawai }}
                </td>
                <td>
                    {{ $item->nohp }}
                </td>
        @endforeach

    </table>
</body>

</html>
