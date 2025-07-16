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
                                    <a href="{{ route('sisipan.pelaksanaan.daftar-mk') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-warning" id="btnBatalKelas">Batalkan Kelas</button>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Buat Kelas</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('sisipan.pelaksanaan.daftar-mk.detail.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <div class="alert alert-info" role="alert" style="padding-bottom:0px">
                                    <p><strong> Cek kembali kesesuaian Dosen Pengampu dengan Jadwal Kelas Perkuliahan di
                                            SITU2, khususnya untuk jadwal yang terdapat beberapa dosen. </strong></p>
                                </div>
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Kode MK</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $matakuliah->idmk }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Nama MK</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $matakuliah->kelasKuliah->namamk }}</span>
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
                                                                NIM
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nama Mahasiswa
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Kelas
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                NIP
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Dosen Pengajar
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Status
                                                            </th>
                                                            <th>
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
                                                                    {{ $item->sisipanajuan->nim }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->sisipanajuan->mahasiswa->nama }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->namakelas }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->krs->kelasKuliah->nip }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->krs->kelasKuliah->namadosen }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->status_ajuan }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <a href="#" class="btn btn-sm btn-warning edit"
                                                                        data-id="{{ $item->id }}"
                                                                        data-idmk="{{ $matakuliah->idmk }}"
                                                                        data-kodeperiode="{{ $matakuliah->kode_periode }}"
                                                                        data-kelas="{{ $item->namakelas }}"
                                                                        data-nip="{{ $item->krs->kelasKuliah->nip }}"
                                                                        data-dosen="{{ $item->krs->kelasKuliah->namadosen }}">
                                                                        <i class="fas fa-edit fa-xs"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('komponen.pagination')
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
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Kelas Sisipan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahDataPerDosen" action="{{ route('sisipan.pelaksanaan.daftar-kelas.tambahPerDosen') }}"
                    method="POST">
                    @csrf
                    <div class="modal-body" style="text-align: center">
                        {{-- <div class="col-12"> --}}
                        {{-- <div class="col-5" style="margin: 15px">
                            <form id="formTambahDataPerMK"
                                action="{{ route('sisipan.pelaksanaan.daftar-kelas.tambahPerMK') }}" method="POST">
                                @csrf

                                <input type="hidden" name="sisipan_periode_id"
                                    value="{{ $matakuliah->sisipanajuan->sisipan_periode_id }}">
                                <input type="hidden" name="kodemk" value="{{ $matakuliah->idmk }}">
                                <input type="hidden" name="kode_periode" value="{{ $matakuliah->kode_periode }}">

                                <button type="submit" class="btn btn-primary" style="width: 200px">Kelas Per MK</button>
                            </form>
                        </div> --}}
                        <p>Apakah anda yakin ingin membuat kelas {{ $matakuliah->idmk }} perdosen?</p>
                        <input type="hidden" name="sisipan_periode_id"
                            value="{{ $matakuliah->sisipanajuan->sisipan_periode_id }}">
                        <input type="hidden" name="kodemk" value="{{ $matakuliah->idmk }}">
                        <input type="hidden" name="kode_periode" value="{{ $matakuliah->kode_periode }}">
                        {{-- <button type="submit" class="btn btn-primary" style="width: 200px">Kelas Per
                                Dosen</button> --}}
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Buatkan Kelas</button>
                    </div>
                </form>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                </div> --}}
            </div>
        </div>
    </div>

    <!-- Modal Batalkan Kelas -->
    <div class="modal fade" id="modalBatalKelas" tabindex="-1" aria-labelledby="modalBatalKelasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBatalKelasLabel">Batalkan Kelas Sisipan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formBatalkanKelas" action="{{ route('sisipan.pelaksanaan.daftar-mk.batalkanKelasAjuan') }}"
                    method="POST">
                    @csrf
                    <div class="modal-body" style="text-align: center">
                        <p>Apakah anda yakin ingin membatalkan kelas {{ $matakuliah->idmk }}?</p>
                        <input type="hidden" name="kodemk" value="{{ $matakuliah->idmk }}">
                        <input type="hidden" name="kode_periode" value="{{ $matakuliah->kode_periode }}">
                        <input type="hidden" name="sisipan_periode_id"
                            value="{{ $matakuliah->sisipanajuan->sisipan_periode_id }}">

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Batalkan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDataLabel">Edit Pengajar Utama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditData" method="POST"
                    action='{{ route('sisipan.pelaksanaan.daftar-mk.editKelasAjuan') }}'>
                    <div class="modal-body">
                        @csrf
                        @method('PUT') <!-- Tambahkan method PUT untuk update data -->
                        <div class="mb-3">
                            <label for="editNamaDosen" class="form-label">Dosen Pengajar</label>
                            <input type="text" class="form-control typeahead" name="subjek_penilaian"
                                id="editNamaDosen" placeholder="Masukkan NIP atau Nama Pegawai" value="">
                            <input type="hidden" id="editNipDosen" name="editNipDosen" value="" required>
                            <input type="hidden" id="editKelas" name="editKelas" value="" required>
                            <input type="hidden" name="editIdMK" id='editIdMK' value="">
                            <input type="hidden" name="editKodePeriode" id='editKodePeriode' value="">
                            {{-- <input type="text" name="editSisipanAjuanId" id="editSisipanAjuanId"> --}}
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
