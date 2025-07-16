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
            <th style="text-align: center;vertical-align: middle;">No</th>
            <th style="text-align: center;vertical-align: middle;">Periode Sisipan</th>
            <th style="text-align: center;vertical-align: middle;">Program Studi</th>
            <th style="text-align: center;vertical-align: middle;">NIM</th>
            <th style="text-align: center;vertical-align: middle;">Total Pembayaran</th>
            <th style="text-align: center;vertical-align: middle;">Status Ajuan</th>
            <th style="text-align: center;vertical-align: middle;">Tanggal Registrasi</th>
            <th style="text-align: center;vertical-align: middle;">Tanggal Transfer</th>
            <th style="text-align: center;vertical-align: middle;">Diverifikasi Oleh</th>
            <th style="text-align: center;vertical-align: middle;">Kode MK</th>
            <th style="text-align: center;vertical-align: middle;">Nama MK</th>
            <th style="text-align: center;vertical-align: middle;">Harga Sisipan</th>
        </tr>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->sisipanajuan->sisipanperiode->nama_periode }}</td>
                <td>{{ $row->sisipanajuan->programstudi }}</td>
                <td>{{ $row->sisipanajuan->nim }}</td>
                <td>{{ $row->sisipanajuan->jumlah_bayar }}</td>
                <td>{{ $row->sisipanajuan->status_pembayaran }}</td>
                <td>{{ $row->sisipanajuan->tgl_pengajuan }}</td>
                <td>{{ $row->sisipanajuan->tgl_pembayaran ? $row->sisipanajuan->tgl_pembayaran : '-' }}</td>
                <td>{{ $row->sisipanajuan->verified_by ? $row->sisipanajuan->verified_by : '-' }}</td>
                <td>{{ $row->idmk }}</td>
                <td>{{ $row->krs->namamk }}</td>
                <td>{{ $row->harga_sisipan }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
