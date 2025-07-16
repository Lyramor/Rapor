@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('sisipan.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Pelaksanaan Sisipan</h3>
                        <p>Daftar Matakuliah Sisipan</p>
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

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <form id="formPeriode" action="{{ route('sisipan.pelaksanaan.daftar-mk') }}" method="GET">
                                @csrf
                                <div class="col-12" style="padding: 10px">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <label for="periodeTerpilih" class="col-form-label"><strong>Periode
                                                    Sisipan</strong></label>
                                        </div>
                                        <div class="col-4">
                                            <select id="periode-dropdown" class="form-select"
                                                aria-label="Default select example" name="periodeTerpilih">
                                                <option value="{{ $periodeTerpilih->id }}">
                                                    {{ $periodeTerpilih->nama_periode }}</option>
                                                @foreach ($daftar_periode as $periode)
                                                    @if ($periode->id != $periodeTerpilih->id)
                                                        <option value="{{ $periode->id }}">
                                                            {{ $periode->nama_periode }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="programStudi" class="col-form-label"><strong>Program Studi
                                                </strong></label>
                                        </div>
                                        <div class="col-4">
                                            @include('komponen.dropdown-unitkerja')
                                        </div>
                                        <div class="col-2 mt-3">
                                            <label for="search" class="col-form-label"><strong>Cari Matakuliah
                                                </strong></label>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <input type="text" class="form-control" id="search"
                                                placeholder="Cari berdasarkan Kode / Nama MK" name="search"
                                                value="{{ old('search') }}">
                                        </div>

                                        <div class="col-2 mt-3">
                                            <label for="search" class="col-form-label"><strong>Status Kelas
                                                </strong></label>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <select id="status_ajuan" class="form-select"
                                                aria-label="Default select example" name="status_ajuan">
                                                <option value="all">Semua Status</option>
                                                <option value="Konfirmasi Kelas">Konfirmasi Kelas</option>
                                                <option value="Diterima">Diadakan</option>
                                                <option value="Dibatalkan">Dibatalkan</option>
                                            </select>
                                        </div>

                                        <div class="col-2 mt-3">
                                        </div>
                                        <div class="col-2 mt-3">
                                            <button id="btn-cari-filter" style="width: 100px; color:white"
                                                class="btn btn-primary" type="submit">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="" style="margin-top: 10px">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Daftar Matakuliah Sisipan</h5>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table table-hover" id="editableTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="text-align: center;vertical-align: middle;">
                                                No
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Program Studi
                                            </th>
                                            <th>Kode</th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama Matakuliah
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Jumlah Peserta
                                            </th>
                                            <th>
                                                Status Kelas
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-body" class="text-center">
                                        @if ($data->count() > 0)
                                            @foreach ($data as $mk)
                                                <tr style="text-align: center;vertical-align: middle;">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $mk->matakuliah->programstudi }}</td>
                                                    <td>{{ $mk->idmk }}</td>
                                                    <td>{{ $mk->matakuliah->namamk }}</td>
                                                    <td>{{ $mk->total_peserta }}</td>
                                                    @if ($mk->status_ajuan == 'Diterima')
                                                        <td><span class="badge bg-success">Diadakan</span>
                                                        </td>
                                                    @elseif ($mk->status_ajuan == 'Dibatalkan')
                                                        <td><span class="badge bg-danger">{{ $mk->status_ajuan }}</span>
                                                        </td>
                                                    @else
                                                        <td><span class="badge bg-warning">{{ $mk->status_ajuan }}</span>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <form action="{{ route('sisipan.pelaksanaan.daftar-mk.peserta') }}"
                                                            method="get">
                                                            @csrf
                                                            <input type="hidden" name="idmk"
                                                                value="{{ $mk->idmk }}">
                                                            <input type="hidden" name="kode_periode"
                                                                value="{{ $mk->kode_periode }}">
                                                            <input type="hidden" name="programstudi"
                                                                value="{{ $mk->matakuliah->programstudi }}">
                                                            <button type="submit" class="btn btn-primary btn-sm"> <i
                                                                    class="fas fa-edit fa-xs"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">Tidak ada data.</td>
                                            </tr>
                                        @endif
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
    <div class="modal fade" id="modalDetailData" tabindex="-1" aria-labelledby="modalDetailDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailDataLabel">Detail Ajuan Sisipan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formTambahData" action="{{ route('sisipan.ajuan.verifikasiAjuan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sisipan_ajuan_id" id="sisipan_ajuan_id">
                    <div class="modal-body">
                        <div class="row" style="">
                            <p><strong>Pastikan untuk mengecek bukti transfer sudah sesuai dengan tagihan
                                    yang ada.</strong></p>
                        </div>
                        <table class="table table-bordered" id="tabelData">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode MK</th>
                                    <th>Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Nilai Angka</th>
                                    <th>Grade</th>
                                    <th>Harga</th>
                                    {{-- <th><input type="checkbox" id="checkAll"></th> --}}
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total Bayar:</strong></td>
                                    <td colspan="2" id="buktiPembayaran"></td>
                                    <td id="totalBayar"></td>
                                    {{-- <td></td> --}}
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="modal-footer">
                        {{-- <div class="col-5"> --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    </div>
                    <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btnDetailData', function() {
                var id = $(this).data('id'); // Ambil ID dari atribut data-id
                $('#sisipan_ajuan_id').val(id);
                var buktiPembayaran = $(this).data('bukti'); // Ambil ID dari atribut data-id

                $.ajax({
                    url: '{{ url('/sisipan/ajuan/detail') }}/' + id,
                    type: 'GET',
                    success: function(response) {
                        // Isi modal dengan data dari response
                        $('#modalDetailData #modalDetailDataLabel').text(
                            'Detail Ajuan Sisipan');
                        var tbody = $('#modalDetailData #tabelData tbody');
                        var totalBayar = 0;
                        tbody.empty(); // Kosongkan tbody
                        $.each(response, function(index, item) {
                            totalBayar += parseFloat(item.harga_sisipan);
                            tbody.append(
                                '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + item.krs.idmk + '</td>' +
                                '<td>' + item.krs.namamk + '</td>' +
                                '<td>' + item.krs.sksmk + '</td>' +
                                '<td>' + (item.krs.nnumerik ? item.krs.nnumerik :
                                    'N/A') + '</td>' +

                                '<td>' + (item.krs.nhuruf ? item.krs.nhuruf :
                                    'N/A') + '</td>' +
                                '<td>' + formatRupiah(item.harga_sisipan) +
                                '</td>' +
                                // '<td><input type="checkbox" class="form-check-input checkbox-data" name="data[]" value="' +
                                // item.id + '" /></td>' +

                                '</tr>');
                        });
                        $('#buktiPembayaran').html('<a href="' + buktiPembayaran +
                            '" target="_blank">Lihat Bukti Pembayaran</a>');
                        $('#totalBayar').text(formatRupiah(totalBayar));
                        $('#modalDetailData').modal('show');
                    },
                    error: function(response) {
                        console.error('Error:', response);
                    }
                });
            });

            $('#checkAll').change(function() {
                $('.checkbox-data').prop('checked', $(this).prop('checked'));
            });

            $('#formTambahData').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');

                if (confirm('Apakah Anda yakin ingin menyetujui data ajuan sisipan ini?')) {
                    $('#loadingSpinner').show();

                    $.ajax({
                        url: url,
                        method: method,
                        data: form.serialize(),
                        success: function(response) {
                            alert('Data berhasil diverifikasi.');
                            $('#loadingSpinner').hide();
                            $('#modalDetailData').modal(
                                'hide'); // Menutup modal setelah berhasil
                            window.location.reload(); // Memuat ulang halaman setelah berhasil
                        },
                        error: function(xhr, status, error) {
                            $('#loadingSpinner').hide();
                            alert('Terjadi kesalahan, silakan coba lagi.');
                            console.error(error);
                        }
                    });
                }
            });

        });

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }
    </script>
@endsection
