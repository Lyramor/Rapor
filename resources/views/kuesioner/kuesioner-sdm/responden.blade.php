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
                        <p>Responden Kegiatan Kuesioner</p>
                    </span>
                </div>
            </div>
        </div>
        {{-- tampilkan message session success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                        <button class="btn btn-primary" id="btnTambahResponden">Tambah Responden</button>
                                    </div>

                                    <form action="{{ route('deleteAllResponden') }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua responden?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" value="{{ $data->id }}" name="kuesioner_sdm_id">
                                        <button type="submit" class="btn btn-danger">Hapus Semua Responden</button>
                                    </form>

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
                                            {{ \Carbon\Carbon::parse($data->jadwal_kegiatan_mulai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                            -
                                            {{ \Carbon\Carbon::parse($data->jadwal_kegiatan_selesai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
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
                                                                NIP
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nama
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Unit Kerja
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Status Selesai
                                                            </th>

                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        {{-- foreach untuk soalKuesionerSDM --}}
                                                        @foreach ($responden as $item)
                                                            <tr>
                                                                <td hidden>{{ $item->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->pegawai_nip }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->pegawai->nama }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->pegawai->unitKerja->nama_unit }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    @if ($item->status_selesai)
                                                                        <i class="fas fa-check-circle"
                                                                            style="color: green"></i>
                                                                    @else
                                                                        <i class="fas fa-times-circle"
                                                                            style="color: red"></i>
                                                                    @endif
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
    <!-- Modal Tambah Responden -->
    <div class="modal fade" id="modalTambahResponden" tabindex="-1" aria-labelledby="modalTambahRespondenLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahRespondenLabel">Tambah Responden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formTambahResponden" action="{{ route('tambahResponden') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 10px">
                            <p>Silahkan pilih terlebih dahulu unit kerja atau masukan nama pegawai </p>
                            <input type="hidden" value="{{ $data->id }}" name="kuesioner_sdm_id"
                                id="kuesioner_sdm_id">
                            <div class="col-sm-3">
                                <select class="form-select" name="unit_kerja" id="unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitkerja as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control typeahead" id="nama_pegawai"
                                    name="nama_pegawai" placeholder="Masukkan NIP atau Nama Pegawai">
                            </div>
                            <div class="col-sm-3">
                                <button id="btn-cari-filter" color:white" class="btn btn-primary" type="button"
                                    form="">Cari</button>
                                <button id="btn-refresh" style="color:white" class="btn btn-info" type="button"
                                    form="">Refresh</button>
                            </div>
                        </div>
                        <table class="table table-bordered" id="tabelPegawai">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Unit Kerja</th>
                                    {{-- <th>Unit Kerja</th> --}}
                                    <th><input type="checkbox" id="checkAll"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data pegawai akan ditampilkan di sini -->
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        {{-- <ul class="pagination justify-content-center" id="pagination"> --}}
                        <!-- Pagination akan ditampilkan di sini -->
                        {{-- </ul> --}}
                        {{-- @include('komponen.pagination') --}}
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
            const btnCari1 = document.querySelector("#btn-cari-filter");
            const btnCari2 = document.querySelector("#btn-refresh");

            // Tampilkan modal tambah responden
            $('#btnTambahResponden').click(function() {
                $('#tabelPegawai tbody').empty();
                // getData(); // Panggil fungsi getData saat tombol ditekan
                $('#modalTambahResponden').modal('show');
            });

            btnCari1.addEventListener("click", function() {
                searchData(1); // Memanggil searchData dengan parameter 1 untuk halaman pertama
            });

            btnCari2.addEventListener("click", function() {
                // getData(); // Memanggil searchData dengan parameter 1 untuk halaman pertama
                $('#tabelPegawai tbody').empty();
                document.querySelector("input[name='nama_pegawai']").value = '';
                document.getElementById('unit_kerja').value = '';
            });

            function searchData(page) {
                const query = document.querySelector("input[name='nama_pegawai']").value;
                const unitKerja = document.getElementById('unit_kerja').value;

                // Jika query tidak kosong, tambahkan parameter search ke dalam objek 
                var dataToSend = {
                    kuesioner_sdm_id: document.getElementById('kuesioner_sdm_id').value,
                };
                if (query) {
                    dataToSend.search = query;
                }

                // Jika unit kerja tidak kosong, tambahkan parameter unit_kerja ke dalam objek data
                if (unitKerja) {
                    dataToSend.unit_kerja = unitKerja;
                }

                // Kirim permintaan AJAX ke server dengan opsi yang dipilih
                $.ajax({
                    url: "{{ route('getDataResponden') }}",
                    method: "GET",
                    data: dataToSend,
                    success: function(response) {
                        updateTable(response);
                        // updatePagination(response); // Memanggil fungsi updatePagination dengan response
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Terjadi kesalahan, silakan coba lagi.");
                    }
                });
            }

            function getData(page = 1) {
                $.ajax({
                    url: "{{ route('getDataPegawai') }}",
                    type: 'GET',
                    data: {
                        page: page
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateTable(response);
                        // updatePagination(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
                    }
                });
            }

            function updateTable(response) {
                if (response.data.length === 0) {
                    var emptyRow =
                        '<tr><td colspan="4" class="text-center">Data Pegawai Kosong</td></tr>';
                    $('#tabelPegawai tbody').html(emptyRow);
                } else {
                    $('#tabelPegawai tbody')
                        .empty(); // Kosongkan tabel sebelum menambahkan data baru
                    $.each(response.data, function(index, pegawai) {
                        var row = '<tr>' +
                            '<td>' + ((response.current_page - 1) * response.per_page +
                                index + 1) + '</td>' +
                            '<td>' + pegawai.nip + '</td>' +
                            '<td>' + pegawai.nama + '</td>' +
                            '<td>' + pegawai.unit_kerja.nama_unit + '</td>' +
                            // Mengganti unit_kerja menjadi unit_kerja.nama_unit
                            '<td>' +
                            '<div class="form-check">' +
                            '<input class="form-check-input checkbox-pegawai" type="checkbox" name="pegawai[]" value="' +
                            pegawai.nip + '">' +
                            // Menggunakan nip sebagai value checkbox
                            '</div>' +
                            '</td>' +
                            '</tr>';
                        $('#tabelPegawai tbody').append(row);
                    });
                }
            }

            // Kirim form menggunakan AJAX saat form "Tambah Responden" disubmit
            $('#formTambahResponden').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                // Ubah formData menjadi array untuk mengambil nilai checkbox yang diceklis
                var formDataArray = form.serializeArray();
                var pegawaiTerpilih = [];

                $.each(formDataArray, function(index, element) {
                    if (element.name === 'pegawai[]') {
                        pegawaiTerpilih.push(element.value);
                    }
                });

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        _token: '{{ csrf_token() }}',
                        nip_pegawai: pegawaiTerpilih, // Menggunakan NIP pegawai yang terpilih
                        kuesioner_sdm_id: '{{ $data->id }}' // Menggunakan ID kuesioner SDM
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modalTambahResponden').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
                    }
                });
            });

            $('#checkAll').change(function() {
                $('.checkbox-pegawai').prop('checked', $(this).prop('checked'));
            });

            // Hapus baris tabel
            $('#editableTable').on('click', '.delete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                    var row = $(this).closest('tr');
                    var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                    // Kirim permintaan penghapusan ke server menggunakan Ajax
                    $.ajax({
                        type: "DELETE",
                        url: "/kuesioner/kuesioner-sdm/responden/" + id,
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
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
