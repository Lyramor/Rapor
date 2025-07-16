@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('kuesioner.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Kuesioner SDM</h3>
                        <p>Detail Kegiatan Kuesioner</p>
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
                                    {{-- <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan Judul Soal">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div> --}}
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('kuesioner.kuesioner-sdm') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Tambah Soal</button>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-warning" id="btnSalinSoal">Salin Soal</button>
                                    </div>

                                    {{-- <a href="{{ route('kuesioner.banksoal.create-pertanyaan', ['id' => $data->id]) }}"
                                            class="btn btn-primary" style="color:#fff">Tambah
                                        </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('kuesioner.kuesioner-sdm.sidebar')
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
                                        <span class="input-group-text">{{ $data->periode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Kuisioner</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->nama_kuesioner }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Subjek Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->pegawai->nama }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Jenis Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->jenis_kuesioner }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Unit Kerja</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->pegawai->unitKerja->nama_unit }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Jadwal Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($data->jadwal_kegiatan)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
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
                                                                Nama Soal
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Unsur Penilaian
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Jumlah Soal
                                                            </th>

                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        {{-- foreach untuk soalKuesionerSDM --}}
                                                        @foreach ($soalKuesionerSDM as $item)
                                                            <tr>
                                                                <td hidden>{{ $item->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->soal->nama_soal }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->unsurPenilaian->nama }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->soal->jumlah_pertanyaan }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger delete">
                                                                        <i class="fas fa-trash-alt fa-xs"></i>
                                                                    </button>
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
    <!-- Modal Tambah Soal -->
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahSoal" action="{{ route('kuesioner.soalkuesionersdm.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="unsur-penilaian" class="form-label">Unsur Penilaian</label>
                            <select class="form-select" id="unsur-penilaian" name="unsur_penilaian_id" required>
                                <option value="">Pilih Unsur Penilaian</option>
                                @foreach ($unsurPenilaian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaSoal" class="form-label">Nama Soal</label>
                            <input type="text" class="form-control typeahead" id="namaSoal" name="nama_soal"
                                required autocomplete="off" placeholder="Tuliskan nama soal yang dibuat pada Banksoal">
                            <input type="hidden" id="idSoal" name="id_soal">
                            <input type="hidden" id="idKuesionerSDM" name="id_kuesionerSDM"
                                value="{{ $data->id }}">
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

    <!-- Modal Salin Soal -->
    <div class="modal fade" id="modalSalinSoal" tabindex="-1" aria-labelledby="modalSalinSoalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSalinSoalLabel">Salin Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSalinSoal" action="{{ route('kuesioner.soalkuesionersdm.copy') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaKuesioner" class="form-label">Nama Kuesioner</label>
                            <input type="text" class="form-control typeahead" id="namaKuesioner"
                                name="nama_kuesioner" required autocomplete="off" placeholder="Tuliskan nama kuesioner">
                            <input type="hidden" id="idKuesionerCopy" name="id_kuesioner_copy">
                            <input type="hidden" id="idKuesionerSDM" name="id_kuesionerSDM"
                                value="{{ $data->id }}">
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
                $('#modalTambahSoal').modal('show');
            });

            $('#btnSalinSoal').click(function() {
                $('#modalSalinSoal').modal('show');
            });

            $('#namaSoal').on('input', function() {
                var query = $(this).val();
                // Lakukan AJAX request hanya jika query tidak kosong
                if (query.trim() !== '') {
                    $.ajax({
                        url: "{{ route('kuesioner.banksoal.data') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            // Proses data dari response
                            var data = response;
                            var formattedData = [];
                            $.each(data, function(index, item) {
                                var displayText = item.nama_soal;
                                formattedData.push(displayText);
                            });

                            $('#namaSoal').typeahead({
                                source: formattedData,
                                autoSelect: true,
                                afterSelect: function(item) {
                                    // Set nilai idSoal ke id yang dipilih
                                    var selectedId = '';
                                    $.each(data, function(index, soal) {
                                        if (soal.nama_soal === item) {
                                            selectedId = soal.id;
                                            return false; // Keluar dari loop
                                        }
                                    });
                                    $('#idSoal').val(selectedId);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseText;
                            console.log(errorMessage);
                        }
                    });
                }
            });

            $('#namaKuesioner').on('input', function() {
                var query = $(this).val();
                // Lakukan AJAX request hanya jika query tidak kosong
                if (query.trim() !== '') {
                    $.ajax({
                        url: "{{ route('getKuesionerSDMforCopy') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            // Proses data dari response
                            var data = response;
                            var formattedData = [];
                            $.each(data, function(index, item) {
                                var displayText = item.nama_kuesioner;
                                formattedData.push(displayText);
                            });

                            $('#namaKuesioner').typeahead({
                                source: formattedData,
                                autoSelect: true,
                                afterSelect: function(item) {
                                    // Set nilai idSoal ke id yang dipilih
                                    var selectedId = '';
                                    $.each(data, function(index, KuesionerSDM) {
                                        if (KuesionerSDM.nama_kuesioner ===
                                            item) {
                                            selectedId = KuesionerSDM.id;
                                            return false; // Keluar dari loop
                                        }
                                    });
                                    $('#idKuesionerCopy').val(selectedId);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseText;
                            console.log(errorMessage);
                        }
                    });
                }
            });

            // Kirim form menggunakan AJAX saat form "Tambah Soal" disubmit
            $('#formTambahSoal').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                // Buat objek data yang akan dikirim
                var formData = {
                    _token: '{{ csrf_token() }}',
                    id_soal: $('#idSoal').val(),
                    id_kuesionerSDM: $('#idKuesionerSDM').val(),
                    unsur_penilaian_id: $('#unsur-penilaian').val(),
                    // tambahkan data lain sesuai kebutuhan
                };

                $.ajax({
                    url: url,
                    method: method,
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        console.log(response);
                        $('#modalTambahSoal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
                    }
                });
            });

            // Kirim form menggunakan AJAX saat form "Tambah Soal" disubmit
            $('#formSalinSoal').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                // Buat objek data yang akan dikirim
                var formData = {
                    _token: '{{ csrf_token() }}',
                    id_kuesionerSDM_copy: $('#idKuesionerCopy').val(),
                    id_kuesionerSDM: $('#idKuesionerSDM').val(),
                };

                $.ajax({
                    url: url,
                    method: method,
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        console.log(response);
                        $('#modalSalinSoal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
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
                        url: "/kuesioner/soalkuesionersdm/" + id,
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
