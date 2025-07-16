@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('master.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Pegawai</h3>
                        <p>Daftar Pegawai</p>
                    </span>
                </div>
            </div>
        </div>

        {{-- Tampilkan message session success/error jika ada --}}
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
        <div class="isi-konten" style="margin-top: 0px;">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="text" name="query" id="querySearch" class="form-control"
                                            placeholder="Cari berdasarkan NIP/Nama/Email">
                                        <button id="btn-cari-search" type="button" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        {{-- backbutton --}}
                                        <a href="{{ route('master') }}" class="btn btn-secondary" type="button">Kembali</a>
                                        {{-- addbutton --}}
                                        <a href="{{ route('master.role.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="editableTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="text-align: center;vertical-align: middle;width:10%;">
                                                NIP
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Unit Kerja
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $pegawai)
                                            <tr>
                                                <td style="text-align: center;vertical-align: middle;">{{ $pegawai->nip }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">{{ $pegawai->nama }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{ $pegawai->unitkerja->nama_unit }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{-- <a href="{{ route('master.pegawai.edit', $pegawai->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ route('master.pegawai.delete', $pegawai->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('komponen.pagination')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
