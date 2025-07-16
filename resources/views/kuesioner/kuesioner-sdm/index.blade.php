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
                        <h3>Kegiatan kuesioner SDM</h3>
                        <p>Daftar Kegiatan</p>
                    </span>
                </div>
            </div>
        </div>

        <div class="filter-konten" style="margin-bottom: 10px">
            <div class="row justify-content-md-center">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12" style="padding: 10px">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="periode-dropdown"
                                            class="col-form-label"><strong>Periode</strong></label>
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

        <div class="isi-konten">
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
                                        <a href="{{ route('kuesioner.sdm.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah</a>
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
                                                    Nama kuesioner
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Subjek Penilaian
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">Jenis Penilaian</th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Jadwal Kegiatan Mulai</th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Jadwal Kegiatan Selesai</th>

                                                <th style="text-align: center;vertical-align: middle;">
                                                    Soal diisi
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            {{-- foreach untuk data rapor --}}
                                            @if (count($data) == 0)
                                                <tr style="text-align: center;vertical-align: middle;">
                                                    <td colspan="6">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $kusionerSDM)
                                                    <tr style="text-align: center;vertical-align: middle;">
                                                        <td hidden>{{ $kusionerSDM->id }}</td>
                                                        <td>{{ $kusionerSDM->nama_kuesioner }}</td>
                                                        <td>{{ $kusionerSDM->pegawai->nama }}</td>
                                                        <td>{{ $kusionerSDM->jenis_kuesioner }}</td>
                                                        <td>{{ $kusionerSDM->jadwal_kegiatan_mulai }}</td>
                                                        <td>{{ $kusionerSDM->jadwal_kegiatan_selesai }}</td>
                                                        <td>
                                                            @if ($kusionerSDM->is_soal > 0)
                                                                <i class="fas fa-check-circle" style="color: green"></i>
                                                            @else
                                                                <i class="fas fa-times-circle" style="color: red"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('kuesioner.kuesioner-sdm.detail', ['id' => $kusionerSDM->id]) }}"
                                                                class="btn btn-sm btn-info detail">
                                                                <i class="fas fa-link fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('kuesioner.kuesioner-sdm.edit', ['id' => $kusionerSDM->id]) }}"
                                                                class="btn btn-sm btn-warning edit">
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengunggah file -->
                            <form id="uploadForm" action="{{ route('importKuesionerSDM') }}" method="POST"
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
        // const programStudiDropdown = document.querySelector("#program-studi-dropdown");
        const btnCari1 = document.querySelector("#btn-cari-filter");
        const btnCari2 = document.querySelector("#btn-cari-search");

        btnCari1.addEventListener("click", function() {
            var perPage = document.getElementById("perPage").value;
            fetchData(perPage); // Memanggil fetchData dengan parameter 1 untuk halaman pertama
        });

        btnCari2.addEventListener("click", function() {
            var perPage = document.getElementById("perPage").value;
            searchData(perPage); // Memanggil searchData dengan parameter 1 untuk halaman pertama
        });

        function fetchData(page) {
            const selectedPeriode = periodeDropdown.value;
            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ route('kuesioner.kuesioner-sdm.data') }}",
                method: "GET",
                data: {
                    kode_periode: selectedPeriode,
                    // programstudi: selectedProgramStudi,
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
            const query = document.querySelector("input[name='query']").value;

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ route('kuesioner.kuesioner-sdm.data') }}",
                method: "GET",
                data: {
                    kode_periode: selectedPeriode,
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

            const dataKuisonerSDM = response.data;

            if (dataKuisonerSDM.length === 0) {
                const emptyRow = document.createElement("tr");
                emptyRow.innerHTML = `
                <td colspan="6" class="text-center">Tidak ada data</td>
            `;
                tableBody.appendChild(emptyRow);
                return;
            }

            dataKuisonerSDM.forEach(function(kuesionerSDM) {
                const newRow = document.createElement("tr");
                newRow.style.textAlign = "center";
                newRow.style.verticalAlign = "middle";

                newRow.innerHTML = `
                <td hidden>${kuesionerSDM.id}</td>
                <td>${kuesionerSDM.nama_kuesioner}</td>
                <td>${kuesionerSDM.pegawai.nama}</td>
                <td>${kuesionerSDM.jenis_kuesioner}</td>
                <td>${kuesionerSDM.jadwal_kegiatan_mulai}</td>
                <td>${kuesionerSDM.jadwal_kegiatan_selesai}</td>
                <td>
                    ${kuesionerSDM.publik == 1 ? '<i class="fas fa-check-circle" style="color: green"></i>' : '<i class="fas fa-times-circle" style="color: red"></i>'}
                </td>
                
                <td>
                    <a href="/kuesioner/kuesioner-sdm/detail/${kuesionerSDM.id}" class="btn btn-sm btn-info detail">
                        <i class="fas fa-link fa-xs"></i>
                    </a>
                   
                    <a href="/kuesioner/kuesioner-sdm/${kuesionerSDM.id}" class="btn btn-sm btn-warning edit">
                    <i class="fas fa-edit fa-xs"></i>
                </a> <button type="button" class="btn btn-sm btn-danger delete">
                        <i class="fas fa-trash-alt fa-xs"></i>
                    </button>
                    
                    
                </td>
            `;
                tableBody.appendChild(newRow);
            });
        }

        // Fungsi untuk menangani ketika tombol template dokumen ditekan
        document.getElementById("btn-template-dokumen").addEventListener("click", function() {
            window.location.href = "{{ route('export.downloadTemplateKuesionerSDM') }}";
        });

        // Hapus baris tabel
        $('#editableTable').on('click', '.delete', function() {
            if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: "DELETE",
                    url: "/kuesioner/kuesioner-sdm/" + id,
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
    </script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
