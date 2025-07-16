@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .penilaian {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('kuesioner.penilaian.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Kegiatan kuesioner</h3>
                        <p>Dashboard Penilaian</p>
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

        <div class="isi-konten">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Data Peserta</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="nip_peserta" class="col-form-label">NIP :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->pegawai->nip }}</p>
                                        {{-- <input type="text" id="nip_peserta" class="form-control" value=""> --}}
                                    </div>
                                    <div class="col-3">
                                        <label for="nama_peserta" class="col-form-label">Nama :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="{{ route('kuesioner.penilaian') }}" class="btn btn-primary">Daftar
                                            Kuesioner</a>
                                        <a href="{{ route('kuesioner.penilaian.riwayat') }}" class="btn btn-warning">Riwayat
                                            Kuesioner</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Daftar Kuesioner</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                {{-- jika data kuesioner kosong, maka tampilkan pesan --}}
                                @if ($data_kuisioner->isEmpty())
                                    <div class="alert alert-info" role="alert">
                                        Belum ada kuesioner yang tersedia
                                    </div>
                                @endif
                                @foreach ($data_kuisioner as $item)
                                    <div class="penilaian">
                                        <div class="card-body">
                                            <h5 class="card-title" style="margin-bottom: 15px;">
                                                {{ $item->kuesionerSDM->nama_kuesioner }}
                                            </h5>
                                            <div class="row align-items-center">
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Periode</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">{{ $item->kuesionerSDM->periode->nama_periode }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Penilaian</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <p class="card-text">{{ $item->kuesionerSDM->pegawai->nama }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Jenis Penilaian</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">{{ $item->kuesionerSDM->jenis_kuesioner }}
                                                    </p>

                                                </div>

                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Jadwal</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="card-text">
                                                        {{ \Carbon\Carbon::parse($item->kuesionerSDM->jadwal_kegiatan_mulai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($item->kuesionerSDM->jadwal_kegiatan_selesai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            {{-- jika data penilaian masih kosong, maka tampilkan tombol mulai --}}
                                            {{-- jika data penilaian sudah ada, maka tampilkan tombol lanjutkan --}}
                                            @if ($item->penilaian->isEmpty())
                                                <a href="{{ route('kuesioner.penilaian.mulai', $item->id) }}"
                                                    class="btn btn-primary">Mulai</a>
                                            @else
                                                <a href="{{ route('kuesioner.penilaian.mulai', $item->id) }}"
                                                    class="btn btn-success">Lanjutkan</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
