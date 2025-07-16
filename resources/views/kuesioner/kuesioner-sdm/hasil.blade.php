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
                        <h3>Kuesioner SDM</h3>
                        <p>Responden Kegiatan Kuesioner</p>
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
                                    <a href="{{ route('kuesioner.kuesioner-sdm') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('kuesioner.kuesioner-sdm.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Periode</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->periode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Kuisioner</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->nama_kuesioner }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Subjek Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->pegawai->nama }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Jenis Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->jenis_kuesioner }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Unit Kerja</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->pegawai->unitKerja->nama_unit }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Jadwal Penilaian</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($data->jadwal_kegiatan_mulai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                            -
                                            {{ \Carbon\Carbon::parse($data->jadwal_kegiatan_selesai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body" style="display: flex">

                                        <div class="col-md-6">
                                            <h5>Rekap Penilaian Kuesioner</h5>
                                            <hr>
                                            @foreach ($penilaian as $item)
                                                <div class="form-group row">
                                                    <div class="col-sm-6" style="margin-bottom: 5px;">
                                                        <label for="nama_kuesioner" class=" create-label">
                                                            {{ $item->unsurPenilaian->nama }}
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span
                                                            class="input-group-text">{{ number_format($item->rata_rata, 2) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="myChart" width="50" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Responden -->
    @endsection

    @section('js-tambahan')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var data = @json($datachart);

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Hasil Kuesioner SDM',
                        data: data.values,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        r: {
                            min: 0,
                            max: 5,
                            stepSize: 2
                        }
                    }
                }
            });
        </script>
    @endsection
