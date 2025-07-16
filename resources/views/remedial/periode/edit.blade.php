@extends('layouts.main2')

@section('css-tambahan')
    <style>
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
            <div class="col-10">
                <div class="judul-modul">
                    <span>
                        <h3>Periode Remedial</h3>
                        <p>Edit Periode Remedial</p>
                    </span>
                </div>
            </div>
        </div>

        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-10">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="">
            <div class="row justify-content-md-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('remedial.periode') }}" class="btn btn-secondary"
                                            type="button">Kembali</a>
                                        <button type="submit" class="btn btn-primary" form="form-soal">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('remedial.periode.update', $data->id) }}" method="POST" id="form-soal">
                                @csrf
                                @method('PUT')
                                <div class="">
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="kode_periode"
                                            class="col-sm-3 col-form-label create-label required">Periode
                                            Remedial</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" name="kode_periode" id="kode_periode" required>
                                                {{-- <option value="">Pilih Periode Remedial</option> --}}
                                                @foreach ($periode as $item)
                                                    <option value="{{ $item->kode_periode }}"
                                                        {{ $item->kode_periode == $data->kode_periode ? 'selected' : '' }}>
                                                        {{ $item->nama_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="unit_kerja_id"
                                            class="col-sm-3 col-form-label create-label required">Program Studi</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" name="unit_kerja_id" id="unit_kerja_id" required>
                                                {{-- <option value="">Pilih Program Studi</option> --}}
                                                <option value="{{ $data->unitkerja->id }}" selected>
                                                    {{ $data->unitkerja->nama_unit }}</option>
                                                @foreach ($unitkerja as $unit)
                                                    {{-- <option value="{{ $unit->id }}">{{ $unit->nama_unit }}
                                                    </option> --}}
                                                    @if (empty($unitkerja->childUnit))
                                                        <option value="{{ $unit->id }}">
                                                            {{ $unit->nama_unit }}</option>
                                                    @endif
                                                    {{-- @if (!empty($unit->childUnit))
                                                        @foreach ($unit->childUnit as $child)
                                                            <option value="{{ $child->id }}">&nbsp;&nbsp;
                                                                {{ $child->nama_unit }}</option>
                                                        @endforeach
                                                    @endif --}}
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="nama_periode" class="col-sm-3 col-form-label create-label required">Nama
                                            Program Remedial</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="nama_periode" name="nama_periode"
                                                value="{{ $data->nama_periode }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="format_va" class="col-sm-3 col-form-label create-label required">Format
                                            VA</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="format_va" name="format_va"
                                                value="{{ $data->format_va }}" required>
                                        </div>
                                        <div class="col-sm-2" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="add_nrp" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked"
                                                    {{ $data->add_nrp ? 'checked' : '' }}>
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
                                                name="tanggal_mulai"
                                                value="{{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('Y-m-d\TH:i') }}"
                                                required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="datetime-local" class="form-control" id="tanggal_selesai"
                                                name="tanggal_selesai"
                                                value="{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('Y-m-d\TH:i') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="nilai_batas" class="col-sm-3 col-form-label create-label required">Nilai
                                            Batas</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="nilai_batas" name="nilai_batas"
                                                value="{{ $data->nilai_batas }}" required>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <label for="is_aktif" class="col-sm-3 col-form-label create-label">Aktif?</label>
                                        <div class="col-sm-1" style="padding-top:8px;">
                                            <div class="form-check form-switch">
                                                <input name="is_aktif" class="form-check-input" type="checkbox"
                                                    role="switch" id="flexSwitchCheckChecked"
                                                    {{ $data->is_aktif ? 'checked' : '' }}>
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
