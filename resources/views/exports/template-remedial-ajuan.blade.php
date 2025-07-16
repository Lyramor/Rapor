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
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Periode Remedial</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Program Studi</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">IDMK</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Matakuliah</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Kelas</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">NIP</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Dosen</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">NIM</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Nama Mahasiswa</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Nilai Angka</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Nilai Huruf</th>
            <th rowspan="1" style="text-align: center;vertical-align: middle;">Status Ajuan</th>
        </tr>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->remedialajuan->remedialperiode->nama_periode }}</td>
                <td>{{ $row->remedialajuan->programstudi }}</td>
                <td>{{ $row->idmk }}</td>
                <td>{{ $row->krs->namamk }}</td>
                <td>{{ $row->namakelas }}</td>
                <td>{{ $row->nip }}</td>
                <td>{{ $row->krs->kelasKuliah->namadosen }}</td>
                <td>{{ $row->remedialajuan->nim }}</td>
                <td>{{ $row->remedialajuan->mahasiswa->nama }}</td>
                <td>{{ $row->krs->nnumerik }}</td>
                <td>{{ $row->krs->nhuruf }}</td>
                <td>
                    @if ($row->remedialajuan->status_pembayaran == 'Menunggu Pembayaran')
                        Pendaftaran
                    @else
                        {{ $row->status_ajuan }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
