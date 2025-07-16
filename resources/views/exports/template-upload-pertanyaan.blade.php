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
            <td><strong>Nama Kelompok Soal</strong></td>
            <td colspan="3">
                << Isi Nama Soal>>
            </td>
        </tr>
        <tr>
            <td><strong>Deskripsi Soal</strong></td>
            <td colspan="3">
                << Isi Deskripsi Soal>>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nomor</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Jenis Jawaban</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Pertanyaan</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nilai Min (Khusus Range
                    Nilai)</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Nilai Max (Khusus Range
                    Nilai)</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Text Min (Khusus Range
                    Nilai)</strong></td>
            <td rowspan="1" style="text-align: center;vertical-align: middle;"><strong>Text Max (Khusus Range
                    Nilai)</strong></td>
        </tr>
        <tr>
            <td>
                << Isi Nomor>>
            </td>
            <td>
                << Isi Jenis Jawaban>>
            </td>
            <td>
                << Isi Pertanyaan>>
            </td>
            <td>
                << Isi Nilai Min (misal : 1)>>
            </td>
            <td>
                << Isi Nilai Max (misal : 5)>>
            </td>
            <td>
                << Isi Text Min (Misal : Sangat Tidak Setuju)>>
            </td>
            <td>
                << Isi Text Max (Misal : Sangat Tidak Setuju)>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="7"><strong>Catatan:</strong></td>
        </tr>
        <tr>
            <td colspan="7">Daftar pertanyaan bisa diisi mulai dari baris ke-5. Proses upload akan berhenti
                bila ada kolom Nomor yang kosong.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Kode Jenis Jawaban</strong></td>
        </tr>
        <tr>
            <td><strong>Kode Jenis</strong></td>
            <td><strong>Nama Jenis</strong></td>
        </tr>
        <tr>
            <td>R</td>
            <td>Range Nilai</td>
        </tr>
        <tr>
            <td>E</td>
            <td>Essay</td>
        </tr>
    </table>
</body>

</html>
