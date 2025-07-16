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
                        <h3>Matakuliah Sisipan</h3>
                        <p>Detail Matakuliah</p>
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
                                    <a href="{{ route('sisipan.pelaksanaan.daftar-kelas') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('sisipan.pelaksanaan.kelas.detail.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <form action="">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="nama_kuesioner" class=" create-label">
                                                Kode MK</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="kodemk"
                                                value="{{ $kelas->kodemk }}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="nama_kuesioner" class=" create-label">
                                                Nama MK</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="namamk"
                                                value="{{ $kelas->kelaskuliah->namamk }}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="nama_kuesioner" class=" create-label">
                                                NIP</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="kelas"
                                                value="{{ $kelas->dosen->nip }}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="nama_kuesioner" class=" create-label">
                                                Dosen</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="dosen"
                                                value="{{ $kelas->dosen->nama }}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="nama_kuesioner" class=" create-label">
                                                Kode Edlink</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="kode_edlink"
                                                value="{{ $kelas->kode_edlink }}">
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-warning" id="btnBatalKelas">
                                                Upload Nilai</button>
                                        </div>
                                </form>
                                <!-- keterangan -->
                                <div class="card mt-3">
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
                                                                NIM
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nama
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nilai
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Grade
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="tabel-body">
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->nim }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->mahasiswa->nama }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->nnumerik }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->nhuruf }}
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
@endsection

@section('js-tambahan')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tampilkan modal saat tombol "Tambah Soal" ditekan
            $('#btnTambahSoal').click(function() {
                $('#modalTambahData').modal('show');
            });

            $('#btnBatalKelas').click(function() {
                $('#modalBatalKelas').modal('show');
            });

            // Kirim data ke server saat form modal disubmit
            $('#formTambahDataPerMK').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        alert('Kelas Per Matakuliah berhasil ditambahkan.');
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

            // formBatalkanKelas
            $('#formBatalkanKelas').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        alert('Kelas berhasil dibatalkan.');
                        $('#modalBatalKelas').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });

            $('#formTambahDataPerDosen').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        alert('Kelas Per Dosen berhasil ditambahkan.');
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

            // Tampilkan modal saat tombol "Edit" ditekan
            $('.edit').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var kelas = $(this).data('kelas');
                var nip = $(this).data('nip');
                var dosen = $(this).data('dosen');
                var idmk = $(this).data('idmk');
                var kode_periode = $(this).data('kodeperiode');

                // Isi data dalam modal
                $('#editKelas').val(kelas);
                $('#editNipDosen').val(nip);
                $('#editNamaDosen').val(dosen);
                $('#editIdMK').val(idmk);
                $('#editKodePeriode').val(kode_periode);
                // $('#editSisipanAjuanId').val(id);

                // Tampilkan modal
                $('#modalEditData').modal('show');
            });

            // Inisialisasi Typeahead
            $('#editNamaDosen').typeahead({
                source: function(query, process) {
                    return $.ajax({
                        url: "/pegawai/get-nama-pegawai/",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Format data untuk menampilkan NIP - Nama Dosen
                            var formattedData = [];

                            $.each(data, function(index, item) {
                                var displayText = item.nip + ' - ' + item.nama;
                                formattedData.push(displayText);
                            });

                            return process(formattedData);
                        }
                    });
                },
                autoSelect: true,
                updater: function(item) {
                    var parts = item.split(' - ');
                    $('#editNamaDosen').val(parts[1]); // Set nilai input subjek_penilaian
                    $('#editNipDosen').val(parts[0]); // Set nilai input hidden nip-pegawai
                    return parts[1]; // Tampilkan nama pegawai di input
                }
            });

        });
    </script>
@endsection
