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
                <div class="judul-modul">
                    <span>
                        <h3>Modul</h3>
                        <p>{{ $mode == 'edit' ? 'Edit Modul' : 'Tambah Modul' }}</p>
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
                                    <a href="{{ route('master.modul') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <!-- Tombol Simpan -->
                                    <button type="submit" class="btn btn-primary"
                                        form="form-modul">{{ $mode == 'edit' ? 'Simpan Perubahan' : 'Simpan' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form untuk input data modul -->
                        <form
                            action="{{ $mode == 'edit' ? route('master.modul.update', $modul->id) : route('master.modul.store') }}"
                            method="POST" id="form-modul" enctype="multipart/form-data" class="form-action">
                            @csrf
                            @if ($mode == 'edit')
                                @method('PUT')
                            @endif
                            <div class="row mb-3">
                                <label for="nama_modul" class="col-sm-3 col-form-label required">Nama Modul</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_modul" name="nama_modul"
                                        value="{{ $mode == 'edit' ? $modul->nama_modul : old('nama_modul') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tautan" class="col-sm-3 col-form-label required">Tautan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tautan" name="tautan"
                                        value="{{ $mode == 'edit' ? $modul->tautan : old('tautan') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                                <div class="col-sm-9">
                                    @if ($mode == 'edit' && $modul->icon)
                                        <img src="{{ asset('path/to/icon/' . $modul->icon) }}" alt="Icon"
                                            id="preview-icon" class="preview-image">
                                    @else
                                        <img src="" alt="Icon" id="preview-icon" class="preview-image"
                                            style="display: none;">
                                    @endif
                                    <input type="file" class="form-control" id="icon" name="icon"
                                        accept="image/*" onchange="previewImage(event)">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah icon</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="urutan" class="col-sm-3 col-form-label required">Urutan</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="urutan" name="urutan"
                                        value="{{ $mode == 'edit' ? $modul->urutan : old('urutan') }}" required>
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
    <script>
        // Function untuk menampilkan preview gambar sebelum diupload
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview-icon');
                output.src = reader.result;
                output.style.display = 'block'; // Menampilkan gambar
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
