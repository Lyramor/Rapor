@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('btq.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Jadwal BTQ</h3>
                        <p>Detail</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('btq') }}" class="btn btn-secondary" type="button">Kembali</a>
                                    {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-warning" id="btnBatalKelas">Batalkan Kelas</button>
                                    </div> --}}
                                    {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Simpan</button>
                                    </div> --}}
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <!-- This button triggers form submission -->
                                        <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('btq.jadwal.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <div class="card">
                                    <div class="card-body" style="display: flex">
                                        <div class="col-md-12">
                                            <form id="jadwalForm" action="{{ route('btq.jadwal.store') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- Kode Periode -->
                                                        <div id="block-kode_periode" class="row bord-bottom">
                                                            <label for="kode_periode" class="col-md-5">Periode</label>
                                                            <div class="col-md-7 input-kode_periode"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select id="kode_periode" name="kode_periode"
                                                                    class="form-control required">
                                                                    <option value="">-- Pilih Periode --</option>
                                                                    @foreach ($daftar_periode as $item)
                                                                        <option value="{{ $item->kode_periode }}">
                                                                            {{ $item->nama_periode }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <!-- Add dynamic options here -->
                                                                <p class="help-block">
                                                                    <span id="error-field-kode_periode"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Penguji ID -->
                                                        <div id="block-penguji_id" class="row bord-bottom">
                                                            <label for="penguji_id" class="col-md-5">Pementor ID</label>
                                                            <div class="col-md-7 input-penguji_id"
                                                                style="display:block; word-wrap:break-word;">
                                                                <input class="form-control required" type="text"
                                                                    name="penguji_id" id="penguji_id"
                                                                    value="{{ Auth::user()->username }}" readonly>
                                                                <p class="help-block">
                                                                    <span id="error-field-penguji_id"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Kuota -->
                                                        <div id="block-kuota" class="row bord-bottom">
                                                            <label for="kuota" class="col-md-5">Kuota</label>
                                                            <div class="col-md-7 input-kuota"
                                                                style="display:block; word-wrap:break-word;">
                                                                <input type="number" id="kuota" name="kuota"
                                                                    class="form-control required number text-right"
                                                                    maxlength="4" placeholder="Minimum 10/Sesi"
                                                                    min="10">
                                                                <p class="help-block">
                                                                    <span id="error-field-kuota"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Hari -->
                                                        {{-- <div id="block-hari" class="row bord-bottom">
                                                            <label for="hari" class="col-md-5">Hari</label>
                                                            <div class="col-md-7 input-hari"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select name="hari" id="hari"
                                                                    class="form-control required">
                                                                    <option value="">-- Pilih Hari --</option>
                                                                    <option value="Senin">Senin</option>
                                                                    <option value="Selasa">Selasa</option>
                                                                    <option value="Rabu">Rabu</option>
                                                                    <option value="Kamis">Kamis</option>
                                                                    <option value="Jumat">Jumat</option>
                                                                    <option value="Sabtu">Sabtu</option>
                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-hari"></span>
                                                                </p>
                                                            </div>
                                                        </div> --}}

                                                        <!-- Tanggal -->
                                                        <div id="block-tanggal" class="row bord-bottom">
                                                            <label for="tanggal" class="col-md-5">Tanggal</label>
                                                            <div class="col-md-7 input-tanggal"
                                                                style="display:block; word-wrap:break-word;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon"></div>
                                                                    <input type="date" id="tanggal" name="tanggal"
                                                                        class="form-control input-sm datepicker"
                                                                        placeholder="dd-mm-yyyy">
                                                                </div>
                                                                <p class="help-block">
                                                                    <span id="error-field-tanggal"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Is Active -->
                                                        <div id="block-is_active" class="row bord-bottom">
                                                            <label for="is_active" class="col-md-5">Selesai?</label>
                                                            <div class="col-md-7 input-is_active"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select id="is_active" name="is_active"
                                                                    class="form-control required">
                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Proses">Proses Penilaian</option>
                                                                    <option value="Selesai">Selesai</option>
                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-is_active"></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <!-- Jam Mulai -->
                                                        <div id="block-jam_mulai" class="row bord-bottom">
                                                            <label for="jam_mulai" class="col-md-5">Jam Mulai</label>
                                                            <div class="col-md-7 input-jam_mulai"
                                                                style="display:block; word-wrap:break-word;">
                                                                <input type="time" id="jam_mulai" name="jam_mulai"
                                                                    class="form-control required">
                                                                <p class="help-block">
                                                                    <span id="error-field-jam_mulai"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Jam Selesai -->
                                                        <div id="block-jam_selesai" class="row bord-bottom">
                                                            <label for="jam_selesai" class="col-md-5">Jam Selesai</label>
                                                            <div class="col-md-7 input-jam_selesai"
                                                                style="display:block; word-wrap:break-word;">
                                                                <input type="time" id="jam_selesai" name="jam_selesai"
                                                                    class="form-control required">
                                                                <p class="help-block">
                                                                    <span id="error-field-jam_selesai"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Ruang -->
                                                        <div id="block-ruang" class="row bord-bottom">
                                                            <label for="ruang" class="col-md-5">Ruangan</label>
                                                            <div class="col-md-7 input-ruang"
                                                                style="display:block; word-wrap:break-word;">

                                                                <select name="ruang" id="ruang"
                                                                    class="form-control required">
                                                                    <option value="">-- Pilih Tempat Ujian --
                                                                    </option>
                                                                    <option value="Masjid DKM Ulul Albaab">Masjid DKM Ulul
                                                                        Albaab</option>

                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-ruang"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Peserta -->
                                                        <div id="block-peserta" class="row bord-bottom">
                                                            <label for="peserta" class="col-md-5">Peserta</label>
                                                            <div class="col-md-7 input-peserta"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select class="form-control required" name="peserta"
                                                                    id="peserta">
                                                                    <option value="">-- Pilih Peserta --</option>
                                                                    <option value="L">Laki-laki</option>
                                                                    <option value="P">Perempuan</option>
                                                                    <!-- Add dynamic options here -->
                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-peserta"></span>
                                                                </p>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div> <!-- End Row -->
                                            </form>
                                        </div> <!-- End col-md-12 -->
                                    </div> <!-- End card-body -->
                                </div> <!-- End card -->
                            </div> <!-- End sub-konten -->
                        </div> <!-- End col-10 -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        document.getElementById('btnSimpan').addEventListener('click', function() {
            document.getElementById('jadwalForm').submit();
        });
    </script>
@endsection
