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
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('btq.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="judul-modul">
                    <span>
                        <h3>Laporan BTQ</h3>
                        <p>Daftar Laporan Data BTQ</p>
                    </span>
                </div>
            </div>
        </div>
        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-6">
                    <form action="{{ route('btq.laporan.print') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="btq_periode_id" class="text-right mb-0 pr-2 col-md-3">Periode
                                                BTQ</label>
                                            <select id="periode-dropdown" class="form-select"
                                                aria-label="Default select example" name="btq_periode_id" required>
                                                <option value="">Pilih Periode ...</option>
                                                <option value="20241">20241
                                                </option>
                                                {{-- @foreach ($daftar_periode as $periode)
                                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="program-studi" class="text-right mb-0 pr-2 col-md-3">Program
                                                Studi</label>
                                            @include('komponen.dropdown-unitkerja')
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="nama-laporan" class="text-right mb-0 pr-2 col-md-3">Nama
                                                Laporan</label>
                                            <select name="nama_laporan" id="" class="form-select"
                                                aria-label="Default select example" required>
                                                <option value="">Pilih Laporan ...</option>
                                                <option value="peserta-btq">Daftar Peserta BTQ</option>
                                                {{-- <option value="pembayaran">Daftar Pembayaran btq</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="background-color: white">
                                <button type="submit" class="btn btn-primary float-end">Tampilkan</button>
                                <button type="reset" class="btn btn-secondary float-end me-2">Reset</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
