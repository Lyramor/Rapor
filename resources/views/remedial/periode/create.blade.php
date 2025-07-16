@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .kotak {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            margin-top: 10px;
        }

        .kotak .card {
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('remedial.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="judul-modul">
                    <span>
                        <h3>Periode Remedial</h3>
                        <p>Tambah Periode Remedial</p>
                    </span>
                </div>
            </div>
        </div>
        {{-- tampilkan message session success/error jika ada --}}
        @include('komponen.message-alert')
        <div class="">
            <div class="row justify-content-md-center">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">

                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">

                                        <a href="{{ route('remedial.periode') }}" class="btn btn-secondary"
                                            type="button">Kembali</a>
                                        <button type="submit" class="btn btn-primary" form="form-soal">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="">
                            <form action="{{ route('remedial.periode.store') }}" method="POST" id="form-soal">
                                <div class="">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="kode_periode"
                                            class="col-sm-3 col-form-label create-label required">Periode
                                            Remedial</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" name="kode_periode" id="kode_periode" required>
                                                <option value="">Pilih Periode Remedial</option>
                                                @foreach ($periode as $item)
                                                    <option value="{{ $item->kode_periode }}"
                                                        {{ old('kode_periode') == $item->kode_periode ? 'selected' : '' }}>
                                                        {{ $item->nama_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="unit_kerja_id"
                                            class="col-sm-3 col-form-label create-label required">Fakultas</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" name="unit_kerja_id" id="unit_kerja_id" required>
                                                <option value="">Pilih Fakultas</option>
                                                @foreach ($unitkerja as $unit)
                                                    @if (empty($unitkerja->childUnit))
                                                        <option value="{{ $unit->id }}"
                                                            {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
                                                            {{ $unit->nama_unit }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Nama Indikator -->
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="nama_periode" class="col-sm-3 col-form-label create-label required">Nama
                                            Program Remedial</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="nama_periode" name="nama_periode"
                                                value="{{ old('nama_periode') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="format_va" class="col-sm-3 col-form-label create-label required">Format
                                            VA
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="format_va" name="format_va"
                                                value="{{ old('format_va') }}" required>
                                        </div>
                                        <div class="col-sm-2" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="add_nrp" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked"
                                                    {{ old('add_nrp') ? 'checked' : '' }}>
                                                <label for="add_nrp" class="create-label"> + NRP
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="tanggal_mulai" class="col-sm-3 col-form-label create-label required">Tgl
                                            Mulai & Selesai</label>
                                        <div class="col-sm-3">
                                            <input type="datetime-local" class="form-control" id="tanggal_mulai"
                                                name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="datetime-local" class="form-control" id="tanggal_selesai"
                                                name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="is_aktif" class="col-sm-3 col-form-label create-label">Aktif?
                                        </label>
                                        <div class="col-sm-1" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="is_aktif" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked"
                                                    {{ old('is_aktif') ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
@endsection
