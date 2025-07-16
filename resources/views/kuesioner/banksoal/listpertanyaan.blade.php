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
                        <h3>Bank Soal</h3>
                        <p>Pertanyaan</p>
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
                                    <a href="/kuesioner/banksoal" class="btn btn-secondary" type="button">Kembali</a>
                                    {{-- <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                        data-bs-target="#uploadModal">
                                        Unggah Data
                                    </button> --}}
                                    <a href="{{ route('kuesioner.banksoal.create-pertanyaan', ['id' => $data->id]) }}"
                                        class="btn btn-primary" style="color:#fff">Tambah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('kuesioner.banksoal.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                @csrf
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <label for="nama_soal" class="col-sm-3 col-form-label create-label">Nama
                                        Soal</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nama_soal" name="nama_soal"
                                            value="{{ $data->nama_soal }}" required disabled>
                                    </div>
                                </div>
                                <!-- keterangan -->
                                <div class="card">
                                    <div class="card-body" style="display: flex">
                                        <div class="col-md-12">
                                            <div class="table-container">
                                                <table class="table table-hover">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                No.
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Pertanyaan
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">Jenis
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Waktu Pembuatan</th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        {{-- foreach untuk data rapor --}}
                                                        @if (count($data1) == 0)
                                                            <tr>
                                                                <td colspan="5">Tidak ada data</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($data1 as $pertanyaan)
                                                                <tr>
                                                                    <td style="text-align: center">
                                                                        {{ $pertanyaan->no_pertanyaan }}</td>
                                                                    <td style="text-align: justify;">
                                                                        {!! htmlspecialchars_decode($pertanyaan->pertanyaan) !!}</td>
                                                                    <td>{{ $pertanyaan->jenis_pertanyaan }}</td>
                                                                    <td>{{ $pertanyaan->created_at }}</td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger delete">
                                                                            <i class="fas fa-trash-alt fa-xs"></i>
                                                                        </button>
                                                                        <a href="#"
                                                                            class="btn btn-sm btn-info detail">
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
                                            <div id="pagination-container"
                                                class="d-grid gap-2 d-md-flex justify-content-md-end">

                                                <!-- Tempat untuk menampilkan pagination links -->
                                                <!-- Bagian tombol pagination pada tabel -->
                                                <ul class="pagination justify-content-center">
                                                    <!-- Tombol Previous -->
                                                    <li
                                                        class="page-item {{ $data1->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $data1->url(1) }}" class="page-link">Previous</a>
                                                    </li>

                                                    <!-- Nomor Halaman -->
                                                    @for ($i = 1; $i <= $data1->lastPage(); $i++)
                                                        <li
                                                            class="page-item {{ $data1->currentPage() == $i ? 'active' : '' }}">
                                                            <a href="{{ $data1->url($i) }}"
                                                                class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    <!-- Tombol Next -->
                                                    <li
                                                        class="page-item {{ $data1->currentPage() == $data1->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $data1->url($data1->currentPage() + 1) }}"
                                                            class="page-link">Next</a>
                                                    </li>
                                                </ul>
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
                    <form id="uploadForm" action="{{ route('kuesioner.banksoal.pertanyaan.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- hidden soal_id --}}

                        <input type="hidden" name="soal_id" value="{{ $data->id }}">
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

@endsection

@section('js-tambahan')
    <script>
        document.getElementById("btn-template-dokumen").addEventListener("click", function() {
            window.location.href = "{{ route('export.uploadTemplatePertanyaan') }}";
        });
    </script>
@endsection
