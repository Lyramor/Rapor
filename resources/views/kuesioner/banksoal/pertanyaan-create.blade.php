@extends('layouts.main2')

@section('css-tambahan')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/themes/content/default/content.min.css">
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

        <div class="">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                </div>
                                <div class="col-8">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <a href="{{ route('kuesioner.banksoal.list-pertanyaan', ['id' => $data->id]) }}"
                                            class="btn btn-secondary" type="button">Kembali</a>
                                        <button type="submit" class="btn btn-primary"
                                            form="form-pertanyaan">Simpan</button>
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
                                    <!-- Nama Indikator -->
                                    <div class="form-group row">
                                        <label for="nama_soal" class="col-sm-3 col-form-label create-label">Nama
                                            Soal</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_soal" name="nama_soal"
                                                value="{{ $data->nama_soal }}" required disabled>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- keterangan -->
                                    <form action="/kuesioner/banksoal/pertanyaan/store" method="POST" id="form-pertanyaan">
                                        @csrf
                                        <!-- Nama Indikator -->
                                        <input type="hidden" name="soal_id" value="{{ $data->id }}">
                                        <div class="form-group row">
                                            <label for="no_pertanyaan"
                                                class="col-sm-3 col-form-label create-label required">No</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="no_pertanyaan"
                                                    name="no_pertanyaan" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis_pertanyaan"
                                                class="col-sm-3 col-form-label create-label required">Jenis
                                                Pertanyaan</label>
                                            <div class="col-sm-9">
                                                <select class="form-select" id="jenis_pertanyaan" name="jenis_pertanyaan"
                                                    required>
                                                    <option value="range_nilai">Range Nilai</option>
                                                    <option value="essay">Essay</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="scale-fields">
                                            <div class="col-3"></div>
                                            <label for="scale_range_min"
                                                class="col-sm-1 col-form-label create-label mb-3">Nilai
                                                Min</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="scale_range_min"
                                                    name="scale_range_min" value="1">
                                            </div>
                                            <label for="scale_range_max" class="col-sm-1 col-form-label create-label">Nilai
                                                Max</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="scale_range_max"
                                                    name="scale_range_max" value="5">
                                            </div>
                                            <div class="col-3"></div>
                                            <label for="scale_text_min" class="col-sm-1 col-form-label create-label">Text
                                                Min</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="scale_text_min"
                                                    name="scale_text_min" value="Sangat Tidak Setuju">
                                            </div>
                                            <label for="scale_text_max" class="col-sm-1 col-form-label create-label">Text
                                                Max</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="scale_text_max"
                                                    name="scale_text_max" value="Sangat Setuju">
                                            </div>
                                        </div>
                                        <!-- keterangan -->
                                        <div class="form-group row">
                                            <label for="pertanyaan"
                                                class="col-sm-3 col-form-label create-label required">Pertanyaan</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="pertanyaan" id="pertanyaan" cols="30" rows="10"></textarea>
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
    </div>
    </div>
@endsection

@section('js-tambahan')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.10.2/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#pertanyaan',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });

        // Tampilkan atau sembunyikan field scale berdasarkan pilihan jenis pertanyaan
        document.getElementById('jenis_pertanyaan').addEventListener('change', function() {
            var selectedOption = this.value;
            var scaleFields = document.getElementById('scale-fields');

            if (selectedOption !== 'range_nilai') {
                scaleFields.style.display = 'none';
            } else {
                scaleFields.style.display = '';
            }
        });
    </script>
@endsection
