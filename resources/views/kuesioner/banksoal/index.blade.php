@extends('layouts.main2')

@section('css-tambahan')
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
                        <h3>Bank Soal</h3>
                        <p>Daftar Soal</p>
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

        <div class="isi-konten" style="margin-top: 0px;">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan Nama Soal">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        {{-- <a href="{{ route('indikator-kinerja') }}" class="btn btn-info"
                                            style="color:#fff">Generate Data</a> --}}
                                        {{-- button tambah --}}
                                        <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal">
                                            Unggah Data
                                        </button>
                                        <a href="{{ route('kuesioner.banksoal.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            Soal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-hover" id="editableTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Nama Soal
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Keterangan
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">Jml. Soal</th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Waktu Pembuatan</th>

                                                <th style="text-align: center;vertical-align: middle;">
                                                    Publik
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            {{-- foreach untuk data rapor --}}
                                            @if (count($data) == 0)
                                                <tr>
                                                    <td colspan="6">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $soal)
                                                    <tr style="text-align: center;vertical-align: middle;">
                                                        <td hidden>{{ $soal->id }}</td>
                                                        <td>{{ $soal->nama_soal }}</td>
                                                        <td>{{ $soal->keterangan }}</td>
                                                        <td>{{ $soal->jumlah_pertanyaan }}</td>
                                                        <td>{{ $soal->created_at }}</td>
                                                        <td>
                                                            @if ($soal->publik == 1)
                                                                <i class="fas fa-check-circle" style="color: green"></i>
                                                            @else
                                                                <i class="fas fa-times-circle" style="color: red"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('kuesioner.banksoal.show', ['id' => $soal->id]) }}"
                                                                class="btn btn-sm btn-info detail">
                                                                <i class="fas fa-link fa-xs"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-warning edit">
                                                                <i class="fas fa-edit fa-xs"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-danger delete">
                                                                <i class="fas fa-trash-alt fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tambahkan container untuk pagination di bawah tabel -->
                                @include('komponen.pagination')
                                {{-- <div id="data-info">
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
                                            <a href="{{ $data->url($data->currentPage() + 1) }}" class="page-link">Next</a>
                                        </li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Unggah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengunggah file -->
                            <form id="uploadForm" action="{{ route('kuesioner.banksoal.pertanyaan.upload') }}"
                                method="POST" enctype="multipart/form-data">
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
        const btnCari2 = document.querySelector("#btn-cari-search");

        btnCari2.addEventListener("click", function() {
            searchData(10); // Memanggil searchData dengan parameter 1 untuk halaman pertama
        });

        function searchData(page) {
            const query = document.querySelector("input[name='query']").value;

            // Memeriksa apakah query kosong atau tidak
            const searchData = {
                search: query,
                perPage: page
            };

            // Jika query tidak kosong, sertakan dalam data yang dikirimkan
            if (query.trim() !== "") {
                searchData.search = query;
            }

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ route('getDataSoal') }}",
                method: "GET",
                data: searchData,
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

            const dataSoal = response.data;

            if (dataSoal.length === 0) {
                const emptyRow = document.createElement("tr");
                emptyRow.innerHTML = `
                <td colspan="6" class="text-center">No data available</td>
            `;
                tableBody.appendChild(emptyRow);
                return;
            }

            dataSoal.forEach(function(soal) {
                const newRow = document.createElement("tr");
                newRow.style.textAlign = "center";
                newRow.style.verticalAlign = "middle";
                newRow.innerHTML = `
                <td hidden>${soal.id}</td>
                <td>${soal.nama_soal}</td>
                <td>${soal.keterangan}</td>
                <td>${soal.jumlah_pertanyaan}</td>
                <td>${soal.created_at}</td>
                <td>
                    ${soal.publik == 1 ? '<i class="fas fa-check-circle" style="color: green"></i>' : '<i class="fas fa-times-circle" style="color: red"></i>'}
                </td>
                
                <td>
                    <a href="/kuesioner/banksoal/data-soal/${soal.id}" class="btn btn-sm btn-info detail">
                        <i class="fas fa-link fa-xs"></i>
                    </a>
                   
                    <a href="#" class="btn btn-sm btn-warning edit">
                        <i class="fas fa-edit fa-xs"></i>
                     </a>
                    
                    
                </td>
            `;

                tableBody.appendChild(newRow);
            });
        }

        document.getElementById("btn-template-dokumen").addEventListener("click", function() {
            window.location.href = "{{ route('export.uploadTemplatePertanyaan') }}";
        });
    </script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
