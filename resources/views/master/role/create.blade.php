@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .form-group {
            margin-bottom: 10px;
        }

        .form-action {
            margin: 0px 20px;
        }
    </style>
@endsection

@section('navbar')
    @include('master.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="judul-role">
                    <span>
                        <h3>Role</h3>
                        <p>{{ $mode == 'edit' ? 'Edit Role' : 'Tambah Role' }}</p>
                    </span>
                </div>
            </div>
        </div>
        {{-- Tampilkan pesan success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <!-- Jika ingin menambahkan judul header di sini -->
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <!-- Tombol Kembali -->
                                    <a href="{{ route('master.role') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <!-- Tombol Simpan -->
                                    <button type="submit" class="btn btn-primary"
                                        form="form-role">{{ $mode == 'edit' ? 'Simpan Perubahan' : 'Simpan' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form untuk input data role -->
                        <form
                            action="{{ $mode == 'edit' ? route('master.role.update', $role->id) : route('master.role.store') }}"
                            method="POST" id="form-role" class="form-action">
                            @csrf
                            @if ($mode == 'edit')
                                @method('PUT')
                            @endif
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label required">Nama role</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $mode == 'edit' ? $role->name : old('name') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deskripsi" class="col-sm-3 col-form-label">Deksripsi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="deskripsi" name="deskripsi" id="" cols="30" rows="5">{{ $mode == 'edit' ? $role->deskripsi : old('tautan') }}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
