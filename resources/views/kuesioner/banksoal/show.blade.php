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
                        <p>Detail Soal</p>
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

        <div class="">
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
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">

                                        {{-- //back button  --}}
                                        <a href="{{ URL::previous() }}" class="btn btn-secondary" type="button">Kembali</a>
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
                                    <div class="form-group row">
                                        <label for="keterangan"
                                            class="col-sm-3 col-form-label create-label">Keterangan</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" disabled>{{ $data->keterangan }}</textarea>
                                        </div>
                                    </div>
                                    <!-- Soal Acak -->
                                    <div class="form-group row">
                                        <label for="soal_acak" class="col-sm-3 col-form-label create-label">Soal
                                            Acak?</label>
                                        <div class="col-sm-1" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="soal_acak" class="form-check-input" type="checkbox"
                                                    role="switch" id="soal_acak" disabled>
                                                {{-- if soal_acak is true then checked --}}
                                                @if ($data->soal_acak == true)
                                                    <script>
                                                        document.getElementById('soal_acak').checked = true;
                                                    </script>
                                                @endif
                                            </div>
                                        </div>
                                        <label for="publik" class="col-sm-3 col-form-label create-label">Publik?</label>
                                        <div class="col-sm-4" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="publik" class="form-check-input" type="checkbox"
                                                    role="switch" id="publik" disabled>
                                                @if ($data->publik == true)
                                                    <script>
                                                        document.getElementById('publik').checked = true;
                                                    </script>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-body" style=""> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
