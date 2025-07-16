@extends('layouts.main')

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="judul-modul">
                    <h3>Indikator Kinerja</h3>
                </div>
            </div>
        </div>

        <div class="isi-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <h5>Indikator Kinerja</h5> --}}
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <a href="{{ route('indikator-kinerja') }}" class="btn btn-info"
                                            style="color:#fff">Kembali ke Daftar</a>

                                        <button class="btn btn-success" type="submit" form="form-indikator">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-6">
                                <form action="/rapor/indikator-kinerja/store" id="form-indikator" method="POST">
                                    @csrf
                                    <!-- Nama Indikator -->
                                    <div class="form-group row">
                                        <label for="nama_indikator_kinerja" class="col-sm-5 col-form-label wajib">Nama
                                            Indikator</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="nama_indikator_kinerja"
                                                name="nama_indikator_kinerja" required>
                                        </div>
                                    </div>
                                    <!-- Bobot -->
                                    <div class="form-group row">
                                        <label for="bobot" class="col-sm-5 col-form-label">Bobot</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="bobot" name="bobot"
                                                required>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Urutan -->
                                <div class="form-group row">
                                    <label for="urutan" class="col-sm-5 col-form-label">Urutan</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="urutan" name="urutan" required>
                                    </div>
                                </div>
                                <!-- Type Indikator -->
                                <div class="form-group row">
                                    <label for="type_indikator" class="col-sm-5 col-form-label">Tipe
                                        Indikator</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="type_indikator" name="type_indikator" required>
                                            <option value="">Pilih Tipe Indikator</option>
                                            <option value="kuantitatif">Kuantitatif</option>
                                            <option value="kualitatif">Kualitatif</option>
                                        </select>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
