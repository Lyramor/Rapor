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
    @include('btq.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Kegiatan BTQ</h3>
                        <p>Dashboard</p>
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

        <div class="" style="margin-top: 15px">
            <div class="row justify-content-md-center">
                <div class="col-3">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">{{$countPementor}}</h3>
                            <p class="card-text">Pementor</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">{{$countPeserta}}</h3>
                            <p class="card-text">Peserta</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">{{$countJadwalAktif}}</h3>
                            <p class="card-text">Jadwal Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">{{$countJadwalSelesai}}</h3>
                            <p class="card-text">Jadwal Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="isi-konten">
        <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Rekap Penilaian BTQ</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="nip_peserta" class="col-form-label">NIP/NIM :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->username }}</p>
                                        {{-- <input type="text" id="nip_peserta" class="form-control" value=""> --}}
                                    </div>
                                    <div class="col-3">
                                        <label for="nama_peserta" class="col-form-label">Nama :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="{{ route('btq') }}" class="btn btn-primary">Daftar
                                            Jadwal</a>
                                        <a href="{{ route('btq.riwayat') }}" class="btn btn-warning">Riwayat
                                            Jadwal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Data Penguji</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="nip_peserta" class="col-form-label">NIP/NIM :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->username }}</p>
                                        {{-- <input type="text" id="nip_peserta" class="form-control" value=""> --}}
                                    </div>
                                    <div class="col-3">
                                        <label for="nama_peserta" class="col-form-label">Nama :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="{{ route('btq') }}" class="btn btn-primary">Daftar
                                            Jadwal</a>
                                        <a href="{{ route('btq.riwayat') }}" class="btn btn-warning">Riwayat
                                            Jadwal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Data Penguji</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="nip_peserta" class="col-form-label">NIP/NIM :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->username }}</p>
                                        {{-- <input type="text" id="nip_peserta" class="form-control" value=""> --}}
                                    </div>
                                    <div class="col-3">
                                        <label for="nama_peserta" class="col-form-label">Nama :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="{{ route('btq') }}" class="btn btn-primary">Daftar
                                            Jadwal</a>
                                        <a href="{{ route('btq.riwayat') }}" class="btn btn-warning">Riwayat
                                            Jadwal</a>
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
                                <div class="col-8">
                                    <h5 class="card-title">Daftar Jadwal</h5>
                                </div>
                                <div class="col-4">
                                    {{-- button tambah jadwal --}}
                                    <div class="float-end">
                                        <a href="{{ route('btq.jadwal.create') }}" class="btn btn-primary">Tambah
                                            Jadwal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                {{-- jika data kuesioner kosong, maka tampilkan pesan --}}
                                @if ($jadwal->isEmpty())
                                    <div class="alert alert-info" role="alert">
                                        Belum ada jadwal yang tersedia
                                    </div>
                                @endif
                                @foreach ($jadwal as $item)
                                    <div class="penilaian">
                                        <div class="card-body">
                                            <h5 class="card-title" style="margin-bottom: 15px;">
                                                Jadwal Pengujian BTQ
                                            </h5>
                                            <div class="row align-items-center">
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Periode</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">{{ $item->periode->nama_periode }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Penilaian</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <p class="card-text">Bacaan, Tulisan dan Hafalan Al-Qur'an
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Jumlah Peserta</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">
                                                        @if ($item->peserta == 'P')
                                                            <span class="badge bg-primary">Perempuan -
                                                                {{ $item->jumlahMahasiswaTerdaftar() }}
                                                                /
                                                                {{ $item->kuota }}</span>
                                                        @else
                                                            <span class="badge bg-primary">Laki-laki -
                                                                {{ $item->jumlahMahasiswaTerdaftar() }}
                                                                /
                                                                {{ $item->kuota }}</span>
                                                        @endif
                                                    </p>

                                                </div>

                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Jadwal</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="card-text">
                                                        {{ \Carbon\Carbon::parse($item->jam_mulai)->isoFormat('hh:mm A') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($item->jam_selesai)->isoFormat('hh:mm A') }}
                                                        ,
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="status" class="create-label">
                                                        Status</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">
                                                        <span class="badge bg-success">{{ $item->is_active }}</span>
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Aksi</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    {{-- button edit dan detail --}}
                                                    <a href="{{ route('btq.jadwal.edit', $item->id) }}"
                                                        class="btn btn-warning btn-sm">Detail</a>
                                                    {{-- button hapus --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            {{-- jika data penilaian masih kosong, maka tampilkan tombol mulai --}}
                                            {{-- jika data penilaian sudah ada, maka tampilkan tombol lanjutkan --}}
                                            {{-- @if ($item->penilaian->isEmpty())
                                                <a href="{{ route('kuesioner.penilaian.mulai', $item->id) }}"
                                                    class="btn btn-primary">Mulai</a>
                                            @else
                                                <a href="{{ route('kuesioner.penilaian.mulai', $item->id) }}"
                                                    class="btn btn-success">Lanjutkan</a>
                                            @endif --}}
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
