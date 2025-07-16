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
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Program Studi</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Program</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Periode Masuk</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>NIM</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Status</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Alamat</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Email</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>No HP</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Periode Akhir</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Status Semester</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Semester Terakhir</strong>
            </td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>IPK</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>SKS Lulus</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Rekomendasi Fakultas</strong>
            </td>
        </tr>

        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->programstudi }}</td>
                <td>{{ $item->sistemkuliah }}</td>
                <td>{{ $item->periodemasuk }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->statusmahasiswa }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->nohp }}</td>
                @php
                    // $firstAkm = $item->akm->first();
                    // $firstAkm = $item->akm->firstWhere('statusmhs', 'A');
                    $firstAkm = $item->akm
                        ->filter(function ($akm) {
                            return $akm->idperiode == 20232;
                        })
                        ->first();
                    $skslulusInt = $firstAkm ? (int) $firstAkm->skslulus : null;
                    $tahunAkhir = $firstAkm ? (int) substr($firstAkm->idperiode, 0, 5) : null;
                @endphp
                {{-- <td>{{ $firstAkm->idperiode != null ? $firstAkm->idperiode : '-' }}</td>
                <td>{{ $firstAkm->semmhs != null ? $firstAkm->semmhs : '-' }} </td>
                <td>{{ $firstAkm->ipklulus != null ? $firstAkm->ipklulus : '-' }}</td>
                <td>{{ $firstAkm->skslulus != null ? $firstAkm->skslulus : '-' }}</td> --}}
                <td>{{ $firstAkm ? $firstAkm->idperiode : '-' }}</td>
                <td>{{ $firstAkm ? $firstAkm->statusmhs : '-' }}</td>
                <td>{{ $firstAkm ? $firstAkm->semmhs : '-' }}</td>
                <td>{{ $firstAkm ? $firstAkm->ipklulus : '-' }}</td>
                <td>{{ $firstAkm ? $firstAkm->skslulus : '-' }}</td>
                <td>
                    @if ($item->statusmahasiswa == 'Aktif' && $skslulusInt > 120 && ($tahunAkhir == '20231' || $tahunAkhir == '20232'))
                        {{ 'Cari informasi terkait dengan tanggal Sidang' }}
                    @elseif ($item->statusmahasiswa == 'Aktif' && $skslulusInt >= 120)
                        {{ 'Dikonfirmasi lanjut atau mengundurkan diri' }}
                    @elseif ($item->statusmahasiswa == 'Aktif' && $skslulusInt < 120)
                        {{ 'Diadvokasi untuk mengundurkan diri' }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
