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
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>No</strong></td>
            {{-- <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>ID</strong></td> --}}
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Periode Akademik</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Program Studi</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Kurikulum</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Kode MK</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama MK</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama Kelas</strong></td>
            {{-- <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Sistem Kuliah</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama Kelas Mahasiswa</strong>
            </td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Kapasitas</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Tanggal Mulai</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Tanggal Selesai</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jumlah Pertemuan</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>MBKM</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Hari</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jam Mulai</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jam Selesai</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jenis Pertemuan</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Metode Pembelajaran</strong>
            </td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama Ruang</strong></td> --}}
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>NIP</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nama Dosen</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Kelas ID</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jumlah Peserta Kelas</strong>
            </td>

            {{-- <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Created At</strong></td> --}}
            {{-- <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Updated At</strong></td> --}}
        </tr>

        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- <td>{{ $item->id }}</td> --}}
                <td>{{ $item->periodeakademik }}</td>
                <td>{{ $item->programstudi }}</td>
                <td>{{ $item->kurikulum }}</td>
                <td>{{ $item->kodemk }}</td>
                <td>{{ $item->namamk }}</td>
                <td>{{ $item->namakelas }}</td>
                {{-- <td>{{ $item->sistemkuliah }}</td> --}}
                {{-- <td>{{ $item->namakelasmhs }}</td> --}}
                {{-- <td>{{ $item->kapasitas }}</td> --}}
                {{-- <td>{{ $item->tanggalmulai }}</td> --}}
                {{-- <td>{{ $item->tanggalselesai }}</td> --}}
                {{-- <td>{{ $item->jumlahpertemuan }}</td> --}}
                {{-- <td>{{ $item->mbkm }}</td> --}}
                {{-- <td>{{ $item->hari }}</td> --}}
                {{-- <td>{{ $item->jammulai }}</td> --}}
                {{-- <td>{{ $item->jamselesai }}</td> --}}
                {{-- <td>{{ $item->jenispertemuan }}</td> --}}
                {{-- <td>{{ $item->metodepembelajaran }}</td> --}}
                {{-- <td>{{ $item->namaruang }}</td> --}}
                <td>{{ $item->nip }}</td>
                <td>{{ $item->namadosen }}</td>
                <td>{{ $item->kelasid }}</td>
                <td>
                    @php
                        // $firstAkm = $item->akm->first();
                        $firstJadwalPerkuliahan = $item->jadwalPerkuliahan->firstWhere('pertemuan', '15');
                        $jumlahPeserta = $firstJadwalPerkuliahan
                            ? (int) $firstJadwalPerkuliahan->jumlahpesertakelas
                            : 0;
                    @endphp
                    {{ $jumlahPeserta }}
                </td>
                {{-- <td>{{ $item->created_at }}</td> --}}
                {{-- <td>{{ $item->updated_at }}</td> --}}
            </tr>
        @endforeach
    </table>
</body>

</html>
