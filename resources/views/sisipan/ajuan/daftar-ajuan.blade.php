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
                        <h3>Ajuan Sisipan</h3>
                        <p>Daftar Ajuan Sisipan</p>
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
                            <form id="formPeriode" action="{{ route('sisipan.ajuan.daftarAjuan') }}" method="GET">
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
                                            <select id="programstudi" class="form-select"
                                                aria-label="Default select example" name="programstudi">
                                                @foreach ($unitkerja as $unit)
                                                    @if ($unit->children_count == 0)
                                                        <option value="{{ $unit->id }}">
                                                            {{ $unit->nama_unit }}</option>
                                                    @else
                                                        <option value="all">
                                                            Semua Program Studi</option>
                                                        @foreach ($unit->childUnit as $child)
                                                            <option value="{{ $child->id }}">&nbsp;&nbsp;
                                                                {{ $child->nama_unit }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 mt-3">
                                            <label for="search" class="col-form-label"><strong>Cari NIM / VA
                                                </strong></label>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <input type="text" class="form-control" id="search"
                                                placeholder="Cari berdasarkan NIM / VA" name="search"
                                                value="{{ old('search') }}">
                                        </div>
                                        <div class="col-2 mt-3">
                                            <label for="search" class="col-form-label"><strong>Status Pembayaran
                                                </strong></label>
                                        </div>
                                        <div class="col-4 mt-3">
                                            {{-- Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Lunas' , 'Ditolak --}}
                                            <select id="status_pembayaran" class="form-select"
                                                aria-label="Default select example" name="status_pembayaran">
                                                <option value="all">Semua Status</option>
                                                <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                                <option value="Lunas">Lunas</option>
                                                <option value="Ditolak">Ditolak</option>
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
                                    <h5>Daftar Ajuan Sisipan</h5>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <button id="btn-tambah-ajuan" style="color:white" class="btn btn-primary"
                                            type="submit">Tambah Ajuan</button>
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
                                                Tanggal Pengajuan
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nomor VA
                                            </th>
                                            <th>NIM</th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama Mahasiswa
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Program Studi
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Total Bayar
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Status Pembayaran
                                            </th>
                                            <th>
                                                Bukti Bayar
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-body" class="text-center">
                                        @if ($data->count() > 0)
                                            @foreach ($data as $ajuan)
                                                <tr style="text-align: center;vertical-align: middle;">
                                                    <td>{{ $ajuan->tgl_pengajuan }}</td>
                                                    <td>{{ $ajuan->va }}</td>
                                                    <td>{{ $ajuan->nim }}</td>
                                                    <td>{{ $ajuan->mahasiswa->nama }}</td>
                                                    <td>{{ $ajuan->programstudi }}</td>
                                                    <td>Rp. {{ number_format($ajuan->total_bayar, 0, ',', '.') }}</td>
                                                    <td>{{ $ajuan->status_pembayaran }}</td>
                                                    <td>
                                                        @if ($ajuan->bukti_pembayaran)
                                                            <a href="{{ asset('storage/' . $ajuan->bukti_pembayaran) }}"
                                                                target="_blank">
                                                                Bukti Pembayaran
                                                            </a>
                                                        @else
                                                            <span class="text-danger">Belum ada bukti pembayaran</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('sisipan.ajuan.detail', $ajuan->id) }}"
                                                            data-id="{{ $ajuan->id }}"
                                                            data-bukti="{{ asset('storage/' . $ajuan->bukti_pembayaran) }}"
                                                            class="btn btn-sm btn-warning btnDetailData">
                                                            <i class="fas fa-edit fa-xs"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">Tidak ada data</td>
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

    <!-- Modal Tambah Ajuan -->
    <div class="modal fade" id="modalTambahAjuan" tabindex="-1" aria-labelledby="modalTambahAjuanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAjuanLabel">Tambah Ajuan Sisipan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahAjuan" action="{{ route('sisipan.ajuan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="sisipan_periode_id" class="form-label">Periode Sisipan</label>
                                <select id="periode-dropdown" class="form-select" aria-label="Default select example"
                                    name="sisipan_periode_id">
                                    <option value="{{ $periodeTerpilih->id }}">{{ $periodeTerpilih->nama_periode }}
                                    </option>
                                    @foreach ($daftar_periode as $periode)
                                        @if ($periode->id != $periodeTerpilih->id)
                                            <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="program_studi" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi" name="program_studi" required>
                                    @foreach ($unitkerja as $unit)
                                        @if ($unit->children_count == 0)
                                            <option value="{{ $unit->nama_unit }}">{{ $unit->nama_unit }}</option>
                                        @else
                                            @foreach ($unit->childUnit as $child)
                                                <option value="{{ $child->nama_unit }}">
                                                    &nbsp;&nbsp;{{ $child->nama_unit }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="total_bayar" class="form-label">Nim / Nama Mahasiswa</label>
                                <input type="text" class="form-control typeahead" id="subjek_penilaian"
                                    name="subjek_penilaian" placeholder="Masukkan NIM atau Nama Mahasiswa" required>
                                <input type="hidden" id="nim" name="nim" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-tambahan')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
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

            $('#btn-tambah-ajuan').on('click', function() {
                $('#modalTambahAjuan').modal('show');
            });

            $('#subjek_penilaian').typeahead({
                source: function(query, process) {
                    // var programStudi = $('#program_studi').val(); // Ambil nilai program studi

                    return $.ajax({
                        url: "/data/get-nama-mahasiswa/",
                        type: 'GET',
                        data: {
                            query: query,
                            // program_studi: programStudi
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Format data untuk menampilkan NIM - Nama Mahasiswa
                            var formattedData = [];

                            $.each(data, function(index, item) {
                                var displayText = item.nim + ' - ' + item.nama;
                                formattedData.push(displayText);
                            });

                            return process(formattedData);
                        }
                    });
                },
                autoSelect: true,
                updater: function(item) {
                    var parts = item.split(' - ');
                    $('#subjek_penilaian').val(parts[1]); // Set nilai input subjek_penilaian
                    $('#nim').val(parts[0]); // Set nilai input hidden nip-pegawai
                    return parts[1]; // Tampilkan nama pegawai di input
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
