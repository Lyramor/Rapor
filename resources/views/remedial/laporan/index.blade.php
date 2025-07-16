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
    @include('remedial.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="judul-modul">
                    <span>
                        <h3>Laporan Remedial</h3>
                        <p>Daftar Laporan Data Remedial</p>
                    </span>
                </div>
            </div>
        </div>
        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-6">
                    <form action="{{ route('remedial.laporan.print') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="remedial_periode_id" class="text-right mb-0 pr-2 col-md-3">Periode
                                                Remedial</label>
                                            <select id="periode-dropdown" class="form-select"
                                                aria-label="Default select example" name="remedial_periode_id" required>
                                                <option value="">Pilih Periode ...</option>
                                                @foreach ($daftar_periode as $periode)
                                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }}
                                                    </option>
                                                @endforeach
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
                                                <option value="ajuan">Daftar Ajuan Remedial</option>
                                                <option value="pembayaran">Daftar Pembayaran Remedial</option>
                                                {{-- <option value="2">Daftar Kelas Remedial</option> --}}
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
