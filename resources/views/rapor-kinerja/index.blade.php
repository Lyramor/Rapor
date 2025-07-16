@extends('layouts.main')

@section('css-tambahan')
    <style>
        /* Style untuk menunjukkan elemen sedang diedit */
        .nama-dosen-col {
            width: 200px;
            /* Atur lebar sesuai kebutuhan Anda */
        }

        .table {
            text-align: center;
            /* Posisikan teks judul tengah */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            /* Berikan garis border */
            padding: 8px;
            /* Atur padding agar konten terlihat lebih rapi */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
            /* Posisikan tabel ke tengah */
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            /* Garis border dengan warna abu-abu muda */
            padding: 10px;
            /* Padding untuk ruang antara konten dan tepi sel */
        }

        .table th {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk judul */
            font-weight: bold;
            /* Teks judul lebih tebal */
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Warna latar belakang untuk baris genap */
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
            /* Warna latar belakang saat baris dihover */
        }

        .table-container {
            max-height: 600px;
            /* Atur tinggi maksimum kontainer */
            overflow: auto;
            /* Tambahkan scrollbar jika konten melebihi tinggi maksimum */
        }

        .vertical-text {
            font-size: 12px;
            writing-mode: vertical-rl;
            /* Menjadikan teks vertikal dari atas ke bawah */
            text-orientation: mixed;
            /* Mengatur orientasi teks */
            white-space: nowrap;
            /* Menjaga teks tetap dalam satu baris */
            transform: rotate(180deg);
            /* Rotasi teks 180 derajat (tegak lurus) */
            transform-origin: 50% 50%;
            /* Pusat rotasi */
        }
    </style>
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="judul-modul">
                    <h3>Beranda</h3>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-body" style="display: flex;">
                            <div class="col-6" style="padding: 10px">
                                <div class="form-label">
                                    <label>
                                        <p> <strong>Periode
                                            </strong></p>
                                    </label>
                                </div>
                                <div class="filter">
                                    <select id="periode-dropdown" class="form-select" aria-label="Default select example">
                                        @foreach ($daftar_periode as $periode)
                                            <option value="{{ $periode->kode_periode }}">{{ $periode->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" style="padding: 10px">
                                <div class="form-label">
                                    <label>
                                        <p> <strong>Program Studi</strong></p>
                                    </label>
                                </div>
                                <div class="filter">
                                    <select id="program-studi-dropdown" class="form-select"
                                        aria-label="Default select example">
                                        @foreach ($daftar_programstudi as $programstudi)
                                            <option value="{{ $programstudi->nama }}">{{ $programstudi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- style untuk tombol upload data --}}
                                <div class="pull-right" style="margin-top:10px;float: right;">
                                    <button id="btn-cari-filter" style="width: 100px; color:white" class="btn btn-primary"
                                        type="button" form="form-indikator">Cari</button>
                                </div>
                            </div>
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

        <div class="isi-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
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
                                        {{-- <a href="{{ route('indikator-kinerja') }}" class="btn btn-info"
                                            style="color:#fff">Generate Data</a> --}}

                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal">
                                            Unggah Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">
                                                    NIP
                                                </th>
                                                <th rowspan="2" class="nama-dosen-col"
                                                    style="text-align: center;vertical-align: middle;">Nama
                                                    Dosen</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">
                                                    Nilai
                                                    BKD</th>
                                                <th colspan="4" style="text-align: center;vertical-align: middle;">
                                                    EDOM
                                                </th>
                                                <th colspan="3" style="text-align: center;vertical-align: middle;">
                                                    EDASEP
                                                </th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">
                                                    Aksi
                                                </th>
                                            </tr>
                                            {{-- <tr>
                                                <th class="vertical-text">Pendidikan</th>
                                                <th class="vertical-text">Penelitian</th>
                                                <th class="vertical-text">PPM</th>
                                                <th class="vertical-text">Penunjangan</th>
                                                <th class="vertical-text">Kewajiban Khusus</th>
                                                <th class="vertical-text">Materi Pembelajaran</th>
                                                <th class="vertical-text">Pengelolaan Kelas</th>
                                                <th class="vertical-text">Proses Pengajaran</th>
                                                <th class="vertical-text">Penilaian</th>
                                                <th class="vertical-text">Atasan</th>
                                                <th class="vertical-text">Sejawat</th>
                                                <th class="vertical-text">Bawahan</th>
                                            </tr> --}}
                                            <tr>
                                                {{-- <th>Pendidikan</th>
                                                <th>Penelitian</th>
                                                <th>PPM</th>
                                                <th>Penunjangan</th>
                                                <th>Kewajiban Khusus</th> --}}
                                                <th>Materi Pembelajaran</th>
                                                <th>Pengelolaan Kelas</th>
                                                <th>Proses Pengajaran</th>
                                                <th>Penilaian Mahasiswa</th>
                                                <th>Atasan</th>
                                                <th>Sejawat</th>
                                                <th>Bawahan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            {{-- foreach untuk data rapor --}}
                                            @if (count($data) == 0)
                                                <tr>
                                                    <td colspan="14">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $rapor)
                                                    <tr>
                                                        <td>{{ $rapor->dosen_nip }}</td>
                                                        <td>{{ $rapor->dosen->nama }}</td>
                                                        <td>{{ $rapor->bkd_total }}</td>
                                                        {{-- <td>{{ $rapor->bkd_penelitian }}</td>
                                                        <td>{{ $rapor->bkd_ppm }}</td>
                                                        <td>{{ $rapor->bkd_penunjang }}</td>
                                                        <td>{{ $rapor->bkd_kewajibankhusus }}</td> --}}
                                                        <td>{{ $rapor->edom_materipembelajaran }}</td>
                                                        <td>{{ $rapor->edom_pengelolaankelas }}</td>
                                                        <td>{{ $rapor->edom_prosespengajaran }}</td>
                                                        <td>{{ $rapor->edom_penilaian }}</td>
                                                        <td>{{ $rapor->edasep_atasan }}</td>
                                                        <td>{{ $rapor->edasep_sejawat }}</td>
                                                        <td>{{ $rapor->edasep_bawahan }}</td>
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
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tambahkan container untuk pagination di bawah tabel -->
                                <div id="data-info">
                                    Total data: <span id="total-data">{{ $total }}</span>
                                </div>
                                <div id="pagination-container" class="mt-3">

                                    <!-- Tempat untuk menampilkan pagination links -->
                                    <!-- Bagian tombol pagination pada tabel -->
                                    <ul class="pagination justify-content-center">
                                        <!-- Tombol Previous -->
                                        <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a href="{{ $data->url(1) }}" class="page-link">Previous</a>
                                        </li>

                                        <!-- Nomor Halaman -->
                                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                                            <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                                                <a href="{{ $data->url($i) }}" class="page-link">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        <!-- Tombol Next -->
                                        <li
                                            class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
                                            <a href="{{ $data->url($data->currentPage() + 1) }}"
                                                class="page-link">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Unggah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengunggah file -->
                            <form id="uploadForm" action="{{ url('/rapor/import-rapor-kinerja') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih File:</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                                {{-- <div class="mb-3">
                                    <button type="button" class="btn btn-success" id="exportExcelModalBtn">Export to
                                        Excel</button>
                                </div> --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" id="btn-template-dokumen"
                                        style="color: white">Template
                                        Dokumen</button>

                                    <button type="submit" class="btn btn-primary">Unggah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
