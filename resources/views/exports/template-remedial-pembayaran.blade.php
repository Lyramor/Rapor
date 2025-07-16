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
            <th style="text-align: center;vertical-align: middle;">Periode Remedial</th>
            <th style="text-align: center;vertical-align: middle;">Program Studi</th>
            <th style="text-align: center;vertical-align: middle;">NIM</th>
            <th style="text-align: center;vertical-align: middle;">Nama Mahasiswa</th>
            <th style="text-align: center;vertical-align: middle;">Total Pembayaran</th>
            <th style="text-align: center;vertical-align: middle;">Tanggal Registrasi</th>
            <th style="text-align: center;vertical-align: middle;">Tanggal Transfer</th>
            <th style="text-align: center;vertical-align: middle;">Diverifikasi Oleh</th>
            <th style="text-align: center;vertical-align: middle;">Kode MK</th>
            <th style="text-align: center;vertical-align: middle;">Harga Remedial</th>
        </tr>
        @foreach ($data as $row)
            @php
                $detailCount = count($row->remedialajuandetail);
            @endphp
            <tr>
                <td rowspan="{{ $detailCount }}">{{ $loop->iteration }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->remedialperiode->nama_periode }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->programstudi }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->nim }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->mahasiswa->nama }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->jumlah_bayar }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->created_at }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->tgl_pembayaran }}</td>
                <td rowspan="{{ $detailCount }}">{{ $row->userverifikasi->name }}</td>

                <!-- Tampilkan detail remedial pertama -->
                <td>{{ $row->remedialajuandetail[0]->idmk }}</td>
                <td>{{ $row->remedialajuandetail[0]->harga_remedial }}</td>
            </tr>

            <!-- Tampilkan detail remedial berikutnya -->
            @for ($i = 1; $i < $detailCount; $i++)
                <tr>
                    <td>{{ $row->remedialajuandetail[$i]->idmk }}</td>
                    <td>{{ $row->remedialajuandetail[$i]->harga_remedial }}</td>
                </tr>
            @endfor
        @endforeach
    </table>
</body>

</html>
