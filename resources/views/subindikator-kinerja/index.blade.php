@extends('layouts.main')

@section('css-tambahan')
    <style>
        /* Style untuk menunjukkan elemen sedang diedit */
        .editable {
            background-color: #f3f3f3;
        }
    </style>
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="judul-modul">
                    <h3>Sub Indikator Kinerja</h3>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-body" style="display: flex;">
                            <div class="form-label col-2" style="margin:5px">
                                <label>
                                    <p> <strong>Indikator Kinerja</strong></p>
                                </label>
                            </div>
                            <div class="filter col-4">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Indikator Kinerja</option>
                                    <option value="1">Unsur BKD Sister</option>
                                    <option value="2">EDOM</option>
                                    <option value="3">EDASEP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="isi-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-body">
                            <table id="editableTable" class="table table-hover">
                                <thead class="text-center">
                                    <th style="width: 5%">#</th>
                                    <th style="width: 40%">Sub Indikator Kinerja</th>
                                    <th style="width: 10%">Target</th>
                                    <th style="width: 10%">Urutan</th>
                                    <th style="width: 25%" class="text-center">Aksi</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
