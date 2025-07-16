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
                        <h3>Kegiatan Kuesioner SDM</h3>
                        <p>{{ $kuesioner->id != null ? 'Ubah Kegiatan' : 'Tambah Kegiatan' }}</p>
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
                                        <a href="{{ route('kuesioner.kuesioner-sdm') }}" class="btn btn-secondary"
                                            type="button">Kembali</a>
                                        <button type="reset" class="btn btn-danger float-end"
                                            form="form-kuesioner">Reset</button>
                                        <button type="submit" class="btn btn-primary" form="form-kuesioner">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-body" style="display: flex; margin-left:30px"> --}}
                        <div class="card-body" style="">
                            <form action="{{ route('kuesioner.kuesioner-sdm.update', ['id' => $kuesioner->id]) }}"
                                method="POST" id="form-kuesioner">
                                @csrf
                                <!-- Nama Indikator -->
                                <input type="hidden" name="id" value="{{ isset($kuesioner) ? $kuesioner->id : '' }}">
                                <div class="form-group row">
                                    <div class="col-1"></div>
                                    <label for="kode_periode"
                                        class="col-sm-3 col-form-label create-label required">Periode</label>
                                    <div class="col-sm-6">
                                        <select id="periode-dropdown" class="form-select"
                                            aria-label="Default select example" name="kode_periode" required>
                                            <option value="">Pilih Periode...</option>
                                            @foreach ($daftar_periode as $periode)
                                                <option value="{{ $periode->kode_periode }}"
                                                    {{ isset($kuesioner) && $kuesioner->kode_periode == $periode->kode_periode ? 'selected' : '' }}>
                                                    {{ $periode->nama_periode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-1"></div>
                                    <label for="nama_soal" class="col-sm-3 col-form-label create-label required">
                                        Kegiatan kuesioner</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nama_kuesioner" name="nama_kuesioner"
                                            value="{{ isset($kuesioner) ? $kuesioner->nama_kuesioner : old('nama_kuesioner') }}"
                                            required placeholder="Nama Kegiatan">
                                    </div>
                                </div>
                                <!-- keterangan -->
                                <div class="form-group row">
                                    <div class="col-1"></div>
                                    <label for="subjek_penilaian"
                                        class="col-sm-3 col-form-label create-label required">Objek
                                        Penilaian</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control typeahead" id="subjek_penilaian"
                                            name="subjek_penilaian" placeholder="Masukkan NIP atau Nama Pegawai"
                                            value="{{ isset($kuesioner) ? $kuesioner->pegawai->nama : '' }}">
                                        <input type="hidden" id="nip" name="nip"
                                            value="{{ isset($kuesioner) ? $kuesioner->subjek_penilaian : '' }}">
                                    </div>
                                </div>
                                <!-- Soal Acak -->
                                <div class="form-group row">
                                    <div class="col-1"></div>
                                    <label for="keterangan" class="col-sm-3 col-form-label create-label required">Jenis
                                        Penilaian</label>
                                    <div class="col-sm-6">
                                        <select class="form-select" id="jenis_kuesioner" name="jenis_kuesioner">
                                            <option value="">Pilih Jenis Penilaian...</option>
                                            <option value="Atasan"
                                                {{ isset($kuesioner) && $kuesioner->jenis_kuesioner == 'Atasan' ? 'selected' : '' }}>
                                                Atasan</option>
                                            <option value="Sejawat"
                                                {{ isset($kuesioner) && $kuesioner->jenis_kuesioner == 'Sejawat' ? 'selected' : '' }}>
                                                Sejawat</option>
                                            <option value="Bawahan"
                                                {{ isset($kuesioner) && $kuesioner->jenis_kuesioner == 'Bawahan' ? 'selected' : '' }}>
                                                Bawahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-1"></div>
                                    <label for="jadwal_kegiatan" class="col-sm-3 col-form-label create-label">Jadwal
                                        Kegiatan</label>
                                    <div class="col-sm-6">
                                        <input type="datetime-local" class="form-control" id="jadwal_kegiatan"
                                            name="jadwal_kegiatan"
                                            value="{{ isset($kuesioner) ? date('Y-m-d\TH:i', strtotime($kuesioner->jadwal_kegiatan)) : old('jadwal_kegiatan') }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Typeahead
            $('#subjek_penilaian').typeahead({
                source: function(query, process) {
                    return $.ajax({
                        url: "/pegawai/get-nama-pegawai/",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Format data untuk menampilkan NIP - Nama Dosen
                            var formattedData = [];

                            $.each(data, function(index, item) {
                                var displayText = item.nip + ' - ' + item.nama;
                                formattedData.push(displayText);
                            });

                            return process(formattedData);
                        }
                    });
                },
                autoSelect: true,
                updater: function(item) {
                    var parts = item.split(' - ');
                    $('#subjek_penilaian').val(parts[1]); // Set nilai input subjek_penilaian
                    $('#nip').val(parts[0]); // Set nilai input hidden nip-pegawai
                    return parts[1]; // Tampilkan nama pegawai di input
                }
            });

            $('#form-filter').on('reset', function() {
                $('#subjek_penilaian').val(''); // Kosongkan nilai input nama-dosen
                $('#nip').val(''); // Kosongkan nilai input hidden nip-dosen
            });
        });
    </script>
@endsection
