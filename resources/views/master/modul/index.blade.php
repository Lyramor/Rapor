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
                        <h3>Modul</h3>
                        <p>Daftar Modul</p>
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
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        {{-- backbutton --}}
                                        <a href="{{ route('master') }}" class="btn btn-secondary" type="button">Kembali</a>
                                        {{-- addbutton --}}
                                        <a href="{{ route('master.modul.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            Modul</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="editableTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama Modul
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Tautan
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">Icon</th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Urutan</th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($moduls as $modul)
                                            <tr>
                                                <td class="text-center">{{ $modul->nama_modul }}</td>
                                                <td class="text-center"><a
                                                        href="{{ route($modul->tautan) }}">{{ $modul->tautan }}</a></td>
                                                <td class="text-center">
                                                    @if ($modul->icon)
                                                        <img src="{{ asset('path/to/icon/' . $modul->icon) }}"
                                                            alt="Icon" style="max-width: 50px; max-height: 50px;">
                                                    @else
                                                        <span class="text-muted">Tidak ada icon</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $modul->urutan }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('master.modul.edit', $modul->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Anda yakin ingin menghapus modul ini?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
