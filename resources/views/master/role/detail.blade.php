@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('master.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Role</h3>
                        <p>Detail Role</p>
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
                                    <a href="{{ route('master.role') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahModul">Tambah Modul</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('master.role.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Name</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="input-group-text">{{ $data->name }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Deksripsi</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" disabled id="" cols="30" rows="5">{{ $data->deskripsi }}</textarea>
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
                                                                Nama Modul
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @foreach ($moduls as $item)
                                                            <tr>
                                                                {{-- td item id, menggunakan input type --}}
                                                                <td hidden>
                                                                    <input type="text" value="{{ $item->id }}">
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->modul->nama_modul }}
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
    <div class="modal fade" id="modalTambahModul" tabindex="-1" aria-labelledby="modalTambahModulLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahModulLabel">Tambah Modul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahRoleModul" action="{{ route('addRoleModul') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-sm-9">
                                <input type="text" class="form-control typeahead" id="nama_pegawai" name="nama_pegawai"
                                    placeholder="Masukkan NIP atau Nama Pegawai">
                            </div>
                            <div class="col-sm-auto">
                                <button id="btn-cari-filter" color:white" class="btn btn-primary" type="button"
                                    form="">Cari</button>
                                <button id="btn-refresh" style="color:white" class="btn btn-info" type="button"
                                    form="">Refresh</button>
                            </div>
                        </div>
                        <table class="table table-bordered" id="tabelModul">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Modul</th>
                                    {{-- <th>Unit Kerja</th> --}}
                                    <th><input type="checkbox" id="checkAll"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data pegawai akan ditampilkan di sini -->
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <ul class="pagination justify-content-center" id="pagination">
                            <!-- Pagination akan ditampilkan di sini -->
                        </ul>
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

            // Tampilkan modal saat tombol "Tambah Responden" ditekan
            $('#btnTambahModul').click(function() {
                $('#tabelModul tbody').empty();
                getData(); // Panggil fungsi getData saat tombol ditekan
                $('#modalTambahModul').modal('show');
            });

            // Deklarasikan fungsi getData di luar event handler
            function getData(page = 1) {
                $.ajax({
                    url: "{{ route('getModulData') }}",
                    type: 'GET',
                    data: {
                        page: page
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateTable(response);
                        updatePagination(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
                    }
                });
            }

            // Fungsi untuk update tabel modul
            function updateTable(response) {
                if (response.data.length === 0) {
                    var emptyRow = '<tr><td colspan="3" class="text-center">Data Modul Kosong</td></tr>';
                    $('#tabelModul tbody').html(emptyRow);
                } else {
                    $('#tabelModul tbody').empty();
                    $.each(response.data, function(index, modul) {
                        var row = '<tr>' +
                            '<td>' + ((response.current_page - 1) * response.per_page + index + 1) +
                            '</td>' +
                            '<td>' + modul.nama_modul + '</td>' +
                            '<td><input type="checkbox" class="form-check-input checkbox-modul" name="modul[]" value="' +
                            modul.id + '"></td>' +
                            '</tr>';
                        $('#tabelModul tbody').append(row);
                    });
                }
            }

            function updatePagination(response) {
                // Tampilkan pagination
                var pagination = '';
                if (response.prev_page_url != null) {
                    pagination +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="' + (
                            response.current_page - 1) + '">Sebelumnya</a></li>';
                }

                for (var i = 1; i <= response.last_page; i++) {
                    var active = (response.current_page === i) ? 'active' : '';
                    pagination += '<li class="page-item ' + active +
                        '"><a class="page-link" href="#" data-page="' + i + '">' + i +
                        '</a></li>';
                }

                if (response.next_page_url != null) {
                    pagination +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="' + (
                            response.current_page + 1) + '">Selanjutnya</a></li>';
                }

                $('#pagination').html(pagination);
            }

            // Pilih halaman ketika tombol pagination diklik
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                getData(page); // Panggil fungsi getData di sini
            });

            // Fungsi untuk checklist semua checkbox
            $('#checkAll').change(function() {
                $('.checkbox-modul').prop('checked', $(this).prop('checked'));
            });

            // Kirim form menggunakan AJAX saat form "Tambah Responden" disubmit
            $('#formTambahRoleModul').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                // Ubah formData menjadi array untuk mengambil nilai checkbox yang diceklis
                var formDataArray = form.serializeArray();
                var roleModulTerpilih = [];

                $.each(formDataArray, function(index, element) {
                    if (element.name === 'modul[]') {
                        roleModulTerpilih.push(element.value);
                    }
                });

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        _token: '{{ csrf_token() }}',
                        role_modul: roleModulTerpilih, // Menggunakan RoleModul yang terpilih
                        role_id: '{{ $data->id }}' // Menggunakan ID kuesioner SDM
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modalTambahRoleModul').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        console.log(errorMessage);
                    }
                });
            });


            // Inisialisasi Typeahead
            $('#nama_pegawai').typeahead({
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
                    $('#subjek_penilaian').val(parts[1]); // Set nilai input subjek_penilaian
                    $('#nip').val(parts[0]); // Set nilai input hidden nip-pegawai
                    return parts[1]; // Tampilkan nama pegawai di input
                }
            });

            const btnCari1 = document.querySelector("#btn-cari-filter");
            const btnCari2 = document.querySelector("#btn-refresh");


            btnCari1.addEventListener("click", function() {
                searchData(1); // Memanggil searchData dengan parameter 1 untuk halaman pertama
            });

            btnCari2.addEventListener("click", function() {
                getData(); // Memanggil searchData dengan parameter 1 untuk halaman pertama
            });

            function searchData(page) {
                const query = document.querySelector("input[name='nama_pegawai']").value;

                // Kirim permintaan AJAX ke server dengan opsi yang dipilih
                $.ajax({
                    url: "{{ route('getModulData') }}",
                    method: "GET",
                    data: {
                        search: query,
                        page: page // Mengirimkan parameter page
                    },
                    success: function(response) {
                        updateTable(response);
                        updatePagination(response); // Memanggil fungsi updatePagination dengan response
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Terjadi kesalahan, silakan coba lagi.");
                    }
                });
            }

            // Hapus baris tabel
            $('#editableTable').on('click', '.delete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                    var row = $(this).closest('tr');

                    // ambil data id dari input type yang ditekan tombol hapus
                    var id = row.find('input[type="text"]').val();

                    // Kirim permintaan penghapusan ke server menggunakan Ajax
                    $.ajax({
                        type: "DELETE",
                        url: "/data/destroy-role-modul/" + id,
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
