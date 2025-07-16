@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('remedial.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Matakuliah Remedial</h3>
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
                                    <a href="{{ route('remedial.pelaksanaan.daftar-mk') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('remedial.pelaksanaan.daftar-mk.detail.sidebar')
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
                                                                Kode MK
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nama Matakuliah
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                NIP
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Dosen
                                                            </th>
                                                            <th>Jumlah Peserta</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                {{-- hidden id --}}
                                                                <td hidden>{{ $item->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->kodemk }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->matakuliah->kelasKuliah->namamk }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->nip }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->dosen->nama }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->jumlahpeserta }}
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
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Kelas Remedial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-12"> --}}
                        <div class="col-5" style="margin: 15px">
                            <form id="formTambahDataPerMK"
                                action="{{ route('remedial.pelaksanaan.daftar-kelas.tambahPerMK') }}" method="POST">
                                @csrf

                                <input type="text" name="remedial_periode_id"
                                    value="{{ $matakuliah->remedialajuan->remedial_periode_id }}">
                                <input type="text" name="kodemk" value="{{ $matakuliah->idmk }}">
                                <input type="text" name="kode_periode" value="{{ $matakuliah->kode_periode }}">

                                <button type="submit" class="btn btn-primary" style="width: 200px">Kelas Per MK</button>
                            </form>
                        </div>
                        <div class="col-5" style="margin: 15px">
                            <form id="formTambahDataPerDosen"
                                action="{{ route('remedial.pelaksanaan.daftar-kelas.tambahPerDosen') }}" method="POST">
                                @csrf
                                <input type="text" name="remedial_periode_id"
                                    value="{{ $matakuliah->remedialajuan->remedial_periode_id }}">
                                <input type="text" name="kodemk" value="{{ $matakuliah->idmk }}">
                                <input type="text" name="kode_periode" value="{{ $matakuliah->kode_periode }}">
                                <button type="submit" class="btn btn-primary" style="width: 200px">Kelas Per
                                    Dosen</button>
                            </form>
                        </div>
                        {{-- </div> --}}
                    </div>

                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                </div> --}}
            </div>
        </div>
    </div>

    <!-- Modal Update Data -->
    <div class="modal fade" id="modalUpdateData" tabindex="-1" aria-labelledby="modalUpdateDataLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateDataLabel">Update Kelas Remedial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="formUpdateData" action="#" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" id="update_id">

                                <div class="mb-3">
                                    <label for="update_kodemk" class="form-label">Kode MK</label>
                                    <input type="text" class="form-control" id="update_kodemk" name="kodemk"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="update_namamk" class="form-label">Nama Matakuliah</label>
                                    <input type="text" class="form-control" id="update_namamk" name="namamk"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="update_nip" class="form-label">Dosen</label>
                                    <input type="text" class="form-control" id="update_nip" name="nip">
                                </div>


                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                        // window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });

            // Tampilkan modal update dan isi data saat tombol edit ditekan
            $('.edit').click(function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text().trim();
                var kodemk = row.find('td:eq(2)').text().trim();
                var namamk = row.find('td:eq(3)').text().trim();
                var nip = row.find('td:eq(3)').text().trim();
                var dosen = row.find('td:eq(4)').text();

                $('#update_id').val(id);
                $('#update_kodemk').val(kodemk);
                $('#update_namamk').val(namamk);
                $('#update_nip').val(nip);
                $('#update_dosen').val(dosen);

                $('#modalUpdateData').modal('show');
            });


        });
    </script>
@endsection
