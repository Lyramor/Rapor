@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .kotak {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            margin-top: 10px;
        }

        .kotak .card {
            /* float: left; */
            /* width: 250px; */
            /* Atur lebar kartu sesuai keinginan */
            margin-right: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('kuesioner.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Beranda</h3>
                        <p>Selamat Datang di Sistem Kuesioner</p>
                    </span>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12" style="padding: 10px">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="inputPassword6" class="col-form-label"><strong>Periode</strong></label>
                                    </div>
                                    <div class="col-5">
                                        <select id="periode-dropdown" class="form-select"
                                            aria-label="Default select example">
                                            @foreach ($daftar_periode as $periode)
                                                <option value="{{ $periode->kode_periode }}">{{ $periode->nama_periode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <div class="pull-right">
                                            <button id="btn-cari-filter" style="width: 100px; color:white"
                                                class="btn btn-primary" type="button" form="form-indikator">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="" style="margin-top: 10px">
            <div class="row justify-content-md-center">
                <div class="col-3">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Informasi 1</h5>
                            <p class="card-text">Isi informasi singkat untuk informasi 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Informasi 2</h5>
                            <p class="card-text">Isi informasi singkat untuk informasi 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Informasi 3</h5>
                            <p class="card-text">Isi informasi singkat untuk informasi 3.</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Informasi 4</h5>
                            <p class="card-text">Isi informasi singkat untuk informasi 4.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="" style="margin-top: 10px">
            <div class="row justify-content-md-center">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan NIP atau Nama Dosen">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">

                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal">
                                            Unggah Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Informasi</h4>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- tampilkan message session success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-11">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js-tambahan')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        const periodeDropdown = document.querySelector("#periode-dropdown");
        const programStudiDropdown = document.querySelector("#program-studi-dropdown");
        const btnCari1 = document.querySelector("#btn-cari-filter");
        const btnCari2 = document.querySelector("#btn-cari-search");

        btnCari1.addEventListener("click", function() {
            fetchData(1); // Memanggil fetchData dengan parameter 1 untuk halaman pertama
        });

        btnCari2.addEventListener("click", function() {
            searchData(1); // Memanggil searchData dengan parameter 1 untuk halaman pertama
        });

        function fetchData(page) {
            const selectedPeriode = periodeDropdown.value;
            const selectedProgramStudi = programStudiDropdown.value;

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ url('api/rapor/rapor-kinerja') }}",
                method: "GET",
                data: {
                    perioderapor: selectedPeriode,
                    programstudi: selectedProgramStudi,
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

        function searchData(page) {
            const selectedPeriode = periodeDropdown.value;
            const selectedProgramStudi = programStudiDropdown.value;
            const query = document.querySelector("input[name='query']").value;

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ url('api/rapor/rapor-kinerja') }}",
                method: "GET",
                data: {
                    perioderapor: selectedPeriode,
                    programstudi: selectedProgramStudi,
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

        function updateTable(response) {
            const tableBody = document.querySelector("#tabel-body");
            tableBody.innerHTML = "";

            const dataRapor = response.data;

            if (dataRapor.length === 0) {
                const emptyRow = document.createElement("tr");
                emptyRow.innerHTML = `
                <td colspan="14" class="text-center">No data available</td>
            `;
                tableBody.appendChild(emptyRow);
                return;
            }

            dataRapor.forEach(function(rapor) {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td>${rapor.dosen_nip}</td>
                <td>${rapor.dosen.nama}</td>
                <td>${rapor.bkd_total}</td>
                <td>${rapor.edom_materipembelajaran}</td>
                <td>${rapor.edom_pengelolaankelas}</td>
                <td>${rapor.edom_prosespengajaran}</td>
                <td>${rapor.edom_penilaian}</td>
                <td>${rapor.edasep_atasan}</td>
                <td>${rapor.edasep_sejawat}</td>
                <td>${rapor.edasep_bawahan}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger delete">
                        <i class="fas fa-trash-alt fa-xs"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-primary save">
                        <i class="fas fa-save fa-xs"></i>
                    </button>
                    <a href="#" class="btn btn-sm btn-info detail">
                        <i class="fas fa-link fa-xs"></i>
                    </a>
                </td>
            `;

                tableBody.appendChild(newRow);
            });
        }
        // Script untuk pagination
        function updatePagination(response) {
            const paginationContainer = document.querySelector("#pagination-container");
            paginationContainer.innerHTML = '';

            const totalPages = response.last_page;
            const currentPage = response.current_page;
            const totalData = response.total; // Menambah total data dari respons

            let paginationHTML = '';

            if (totalPages > 1) {
                paginationHTML += `
            <ul class="pagination justify-content-center">
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="fetchData(${currentPage - 1})">Previous</a>
                </li>`;

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `
                <li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="fetchData(${i})">${i}</a>
                </li>`;
                }

                paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="fetchData(${currentPage + 1})">Next</a>
            </li>
        </ul>`;
            }
            paginationContainer.innerHTML = paginationHTML;

            // Menampilkan total data
            const totalDataElement = document.querySelector("#total-data");
            totalDataElement.textContent = totalData;
        }



        $(document).ready(function() {
            // Simpan data setelah mengedit
            $('#editableTable').on('click', '.save', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                var nama_indikator_kinerja = row.find('td:eq(2)').text();
                var bobot = row.find('td:eq(3)').text();
                var urutan = row.find('td:eq(4)').text();
                var type_indikator = row.find('td:eq(5)').text();

                $.ajax({
                    type: "PUT",
                    url: "/rapor/indikator-kinerja/" + id,
                    data: {
                        nama_indikator_kinerja: nama_indikator_kinerja,
                        bobot: bobot,
                        urutan: urutan,
                        type_indikator: type_indikator,
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT'
                    },
                    success: function(response) {
                        alert('Data berhasil diupdate');
                        // Lakukan sesuatu setelah data berhasil diupdate
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
                        url: "/rapor/indikator-kinerja/" + id,
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

        // document.getElementById("exportExcelModalBtn").addEventListener("click", function() {
        //     /* Ambil elemen tabel yang akan diekspor */
        //     var table = document.querySelector(".table");

        //     /* Buat objek worksheet */
        //     var ws = XLSX.utils.table_to_sheet(table);

        //     /* Buat objek workbook */
        //     var wb = XLSX.utils.book_new();
        //     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        //     /* Konversi workbook ke file Excel dan unduh */
        //     XLSX.writeFile(wb, 'exported_data_modal.xlsx');
        // });

        // Fungsi untuk menangani ketika tombol template dokumen ditekan
        document.getElementById("btn-template-dokumen").addEventListener("click", function() {
            // Mendapatkan nilai dari periode-dropdown dan program-studi-dropdown
            var selectedPeriode = document.getElementById("periode-dropdown").value;
            var selectedProgramStudi = document.getElementById("program-studi-dropdown").value;

            // Mengarahkan pengguna ke URL yang tepat dengan parameter periode dan program studi
            window.location.href = "{{ url('/rapor/download-template-rapor-kinerja') }}?periode=" +
                selectedPeriode + "&program_studi=" + selectedProgramStudi;

        });
    </script>
@endsection
