@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('master.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Role</h3>
                        <p>Detail Role</p>
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
                                    <a href="{{ route('master') }}" class="btn btn-secondary" type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnGetToken">Get Token</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('master.sinkronasi.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="tokenTextarea" class="create-label">
                                            Token</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" readonly id="tokenTextarea" name="access_token" cols="30" rows="5">
@if (session('token_sevima'))
{{ session('token_sevima') }}
@endif
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="tokenTextarea" class="create-label">
                                            Homebase </label>
                                    </div>
                                    <div class="col-sm-10">
                                        {{-- form select option homebase --}}
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>Pilih Homebase</option>
                                            <option value="1">Homebase 1</option>
                                            <option value="2">Homebase 2</option>
                                            <option value="3">Homebase 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="tokenTextarea" class="create-label">
                                            Limit </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputNumber"
                                            placeholder="Masukkan Jumlah Data" value="10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                    </div>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Sinkronisasi</button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="tokenTextarea" class="create-label">
                                            Hasil </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" readonly id="tokenTextarea" name="access_token" cols="30" rows="5"></textarea>
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
    <script>
        document.getElementById('btnGetToken').addEventListener('click', function() {
            $.ajax({
                url: '{{ route('master.sinkronasi.getToken') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.access_token) {
                        // Perbarui isi textarea dengan token yang diterima
                        document.getElementById('tokenTextarea').value = response.access_token;
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error: ' + error);
                }
            });
        });
    </script>
@endsection
