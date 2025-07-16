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
                        <h3>Jadwal Placement Test BTQ</h3>
                        <p>Detail jadwal BTQ</p>
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
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <!-- Button simpan -->
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
                                            <!-- Form edit jadwal -->
                                            <form id="jadwalForm" action="{{ route('btq.jadwal.update', $jadwal->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
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
                                                                        <option value="{{ $item->kode_periode }}"
                                                                            {{ $item->kode_periode == $jadwal->kode_periode ? 'selected' : '' }}>
                                                                            {{ $item->nama_periode }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-kode_periode"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Penguji ID -->
                                                        <div id="block-penguji_id" class="row bord-bottom">
                                                            <label for="penguji_id" class="col-md-5">Penguji ID</label>
                                                            <div class="col-md-7 input-penguji_id"
                                                                style="display:block; word-wrap:break-word;">
                                                                <input class="form-control required" type="text"
                                                                    name="penguji_id" id="penguji_id"
                                                                    value="{{ $jadwal->penguji_id }}">
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
                                                                    maxlength="4" value="{{ $jadwal->kuota }}">
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
                                                                    <option value="Senin"
                                                                        {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>
                                                                        Senin</option>
                                                                    <option value="Selasa"
                                                                        {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>
                                                                        Selasa</option>
                                                                    <option value="Rabu"
                                                                        {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu
                                                                    </option>
                                                                    <option value="Kamis"
                                                                        {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>
                                                                        Kamis</option>
                                                                    <option value="Jumat"
                                                                        {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>
                                                                        Jumat</option>
                                                                    <option value="Sabtu"
                                                                        {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>
                                                                        Sabtu</option>
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
                                                                    <input type="date" id="tanggal" name="tanggal"
                                                                        class="form-control input-sm datepicker"
                                                                        value="{{ $jadwal->tanggal->format('Y-m-d') }}">
                                                                </div>
                                                                <p class="help-block">
                                                                    <span id="error-field-tanggal"></span>
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
                                                                    class="form-control required"
                                                                    value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}">
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
                                                                    class="form-control required"
                                                                    value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}">
                                                                <p class="help-block">
                                                                    <span id="error-field-jam_selesai"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Ruang -->
                                                        <div id="block-ruang" class="row bord-bottom">
                                                            <label for="ruang" class="col-md-5">Ruang</label>
                                                            <div class="col-md-7 input-ruang"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select name="ruang" id="ruang"
                                                                    class="form-control required">
                                                                    <option value="">-- Pilih Tempat Ujian --
                                                                    </option>
                                                                    <option value="Masjid DKM Ulul Albaab"
                                                                        {{ $jadwal->ruang == 'Masjid DKM Ulul Albaab' ? 'selected' : '' }}>
                                                                        Masjid DKM Ulul Albaab</option>
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
                                                                    <option value="L"
                                                                        {{ $jadwal->peserta == 'L' ? 'selected' : '' }}>
                                                                        Laki-laki</option>
                                                                    <option value="P"
                                                                        {{ $jadwal->peserta == 'P' ? 'selected' : '' }}>
                                                                        Perempuan</option>
                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-peserta"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Is Active -->
                                                        <div id="block-is_active" class="row bord-bottom">
                                                            <label for="is_active" class="col-md-5">Status Jadwal</label>
                                                            <div class="col-md-7 input-is_active"
                                                                style="display:block; word-wrap:break-word;">
                                                                <select id="is_active" name="is_active"
                                                                    class="form-control required">
                                                                    {{-- <option value="Aktif">Aktif</option>
                                                                    <option value="Proses">Proses Penilaian</option>
                                                                    <option value="Selesai">Selesai</option> --}}

                                                                    <option value="Aktif"
                                                                        {{ $jadwal->is_active == 'Aktif' ? 'selected' : '' }}>
                                                                        Aktif</option>
                                                                    <option value="Proses"
                                                                        {{ $jadwal->is_active == 'Proses' ? 'selected' : '' }}>
                                                                        Proses Penilaian</option>
                                                                    <option value="Selesai"
                                                                        {{ $jadwal->is_active == 'Selesai' ? 'selected' : '' }}>
                                                                        Selesai</option>

                                                                </select>
                                                                <p class="help-block">
                                                                    <span id="error-field-is_active"></span>
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
