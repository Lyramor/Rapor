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
                        <h3>Role</h3>
                        <p>Daftar Role</p>
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
                                        <a href="{{ route('master.role.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            Role</a>
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
                                                Nama Role
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Deksripsi
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td class="text-center">{{ $role->name }}</td>
                                                <td class="text-center">{{ $role->deskripsi }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('master.role.edit', $role->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    {{-- detail button --}}
                                                    <a href="{{ route('master.role.detail', $role->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-link"></i>
                                                    </a>

                                                    <form action="{{ route('master.role.delete', $role->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Anda yakin ingin menghapus role ini?')">
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
