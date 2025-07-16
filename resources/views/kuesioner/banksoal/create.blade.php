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

        .form-group {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('kuesioner.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="judul-modul">
                    <span>
                        <h3>Bank Soal</h3>
                        <p>Tambah Soal</p>
                    </span>
                </div>
            </div>
        </div>
        {{-- tampilkan message session success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}

                            {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, assumenda. --}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="">
            <div class="row justify-content-md-center">
                <div class="col-8">
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
                                        <a href="/kuesioner/banksoal" class="btn btn-secondary" type="button">Kembali</a>
                                        <button type="submit" class="btn btn-primary" form="form-soal">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-body" style="display: flex; margin-left:30px"> --}}
                        <div class="card-body" style="">
                            <form action="/kuesioner/banksoal/store" method="POST" id="form-soal">
                                <div class="">
                                    @csrf
                                    <!-- Nama Indikator -->
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="nama_soal" class="col-sm-3 col-form-label create-label required">Nama
                                            Soal</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="nama_soal" name="nama_soal"
                                                required>
                                        </div>
                                    </div>
                                    <!-- keterangan -->
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="keterangan"
                                            class="col-sm-3 col-form-label create-label">Keterangan</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Soal Acak -->
                                    <div class="form-group row">
                                        <div class="col-2"></div>
                                        <label for="soal_acak" class="col-sm-6 col-form-label create-label">Soal
                                            Acak?</label>
                                        <div class="col-sm-4" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="soal_acak" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Publik -->
                                    <div class="form-group row">
                                        <div class="col-2"></div>
                                        <label for="publik" class="col-sm-6 col-form-label create-label">Publik?</label>
                                        <div class="col-sm-4" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="publik" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked">
                                            </div>
                                        </div>
                                    </div>
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
@endsection
