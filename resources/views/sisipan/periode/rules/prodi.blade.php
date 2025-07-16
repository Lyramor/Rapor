@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('sisipan.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Sisipan</h3>
                        <p>Aturan Sisipan Program Studi</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('sisipan.periode') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Tambah Aturan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('sisipan.periode.rules.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Periode</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $sisipanperiode->periode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Nama Periode</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $sisipanperiode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Tanggal Mulai</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($sisipanperiode->tanggal_mulai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                        </span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Tanggal Selesai</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($sisipanperiode->tanggal_selesai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                        </span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Aktif</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ $sisipanperiode->is_aktif == 1 ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </div>
                                </div>
                                <!-- keterangan -->
                                <div class="card">
                                    <div class="card-body" style="display: flex">
                                        <div class="col-md-12">
                                            <div class="table-container">
                                                <table class="table table-hover" id="editableTable">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                No.
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Program Studi
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Batas Nilai
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Batas Presensi
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Batas SKS
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td hidden>{{ $item->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->unitkerja->nama_unit }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->nilai_batas }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->presensi_batas }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->batas_sks }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <button class="btn btn-danger delete">Hapus</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Data -->
    <div class="modal modal-xl fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Aturan Sisipan Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahData" action="{{ route('sisipan.periode.prodi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="periode_angkatan" class="form-label">Program Studi</label>
                            <select class="form-select" name="unit_kerja_id" id="unit_kerja_id" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach ($unitkerja as $unit)
                                    @if (!empty($unit->childUnit))
                                        @foreach ($unit->childUnit as $child)
                                            <option value="{{ $child->id }}">&nbsp;&nbsp;
                                                {{ $child->nama_unit }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="nilai_batas" class="col-form-label required">Batas Nilai
                                    (Kurang dari)</label>
                                <input type="number" class="form-control" id="nilai_batas" name="nilai_batas" required>
                                <input type="text" class="form-control" id="idSisipanPeriode" name="idSisipanPeriode"
                                    value="{{ $sisipanperiode->id }}" hidden>
                            </div>
                            <div class="col-sm-4">
                                <label for="nilai_batas" class="col-form-label required">Batas Presensi
                                    (Lebih dari)</label>
                                <input type="number" class="form-control" id="presensi_batas" name="presensi_batas"
                                    required>
                            </div>
                            <div class="col-sm-4">
                                <label for="nilai_batas" class="col-form-label required">Batas SKS
                                    (Kurang dari sama dengan)</label>
                                <input type="number" class="form-control" id="batas_sks" name="batas_sks" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Tampilkan modal saat tombol "Tambah Soal" ditekan
            $('#btnTambahSoal').click(function() {
                $('#modalTambahData').modal('show');
            });

            // Kirim data ke server saat form modal disubmit
            $('#formTambahData').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        alert('Data berhasil disimpan');
                        $('#modalTambahData').modal('hide');
                        $('#formTambahData').trigger('reset');
                        $('#tabel-body').append(response);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });

            // Hapus baris tabel
            $('#editableTable').on('click', '.delete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                    var row = $(this).closest('tr');
                    var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                    // Kirim permintaan penghapusan ke server menggunakan Ajax
                    $.ajax({
                        type: "DELETE",
                        url: "/sisipan/periode/prodi/" + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus');
                            row.remove(); // Hapus baris dari tabel setelah berhasil dihapus
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
