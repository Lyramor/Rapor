@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('remedial.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Ajuan Remedial</h3>
                        <p>Daftar Verifikasi Ajuan Remedial</p>
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
                            <form id="formPeriode" action="{{ route('remedial.ajuan') }}" method="GET">
                                @csrf
                                <div class="col-12" style="padding: 10px">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <label for="periodeTerpilih" class="col-form-label"><strong>Periode
                                                    Remedial</strong></label>
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
                                            <label for="search" class="col-form-label"><strong>Cari NIM / VA
                                                </strong></label>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <input type="text" class="form-control" id="search"
                                                placeholder="Cari berdasarkan NIM / VA" name="search"
                                                value="{{ old('search') }}">
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
                                    <h5>Daftar Ajuan Remedial</h5>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <button id="btn-upload-rekor" style="color:white" class="btn btn-primary"
                                            type="submit">Upload Rekening Koran</button>
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
                                                Total Tagihan
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Total Bayar
                                            </th>
                                            <th>
                                                Tanggal Bayar
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
                                                    <td>Rp. {{ number_format($ajuan->jumlah_bayar, 0, ',', '.') }}</td>
                                                    <td>{{ $ajuan->tgl_pembayaran }}</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $ajuan->bukti_pembayaran) }}"
                                                            target="_blank">
                                                            Bukti Pembayaran
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-id="{{ $ajuan->id }}"
                                                            data-bukti="{{ asset('storage/' . $ajuan->bukti_pembayaran) }}"
                                                            class="btn btn-sm btn-warning btnDetailData">
                                                            <i class="fas fa-edit fa-xs"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">Tidak ada data</td>
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
    <div class="modal fade" id="modalDetailData" tabindex="-1" aria-labelledby="modalDetailDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailDataLabel">Detail Ajuan Remedial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formTambahData" action="{{ route('remedial.ajuan.verifikasiAjuan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remedial_ajuan_id" id="remedial_ajuan_id">
                    <div class="modal-body">
                        <div class="row" style="">
                            <p><strong>Pastikan untuk mengecek terkait dengan bukti transfer sudah sesuai dengan tagihan
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
                        {{-- buatkan form jumlah bayar --}}
                        <div class="row">
                            <div class="col-8" style="text-align: right">
                                <div class="form-group">
                                    <label for="jumlah_bayar" class="col-form-label">Jumlah
                                        Bayar:</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="jumlahBayar" name="jumlah_bayar"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <div class="col-5"> --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning">Tolak</button>
                        <button type="submit" class="btn btn-primary">Setujui</button>
                        {{-- </div> --}}
                    </div>
                    <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Ajuan -->
    <div class="modal fade" id="modalUploadRakor" tabindex="-1" aria-labelledby="modalUploadRakorLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUploadRakorLabel">Upload File Rekening Koran Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" action="{{ route('remedial.ajuan.uploadRekeningKoran') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="remedial_periode_id" class="form-label">Periode Remedial</label>
                                <select id="periode-dropdown" class="form-select" aria-label="Default select example"
                                    name="remedial_periode_id">
                                    <option value="{{ $periodeTerpilih->id }}">{{ $periodeTerpilih->nama_periode }}
                                    </option>
                                    @foreach ($daftar_periode as $periode)
                                        @if ($periode->id != $periodeTerpilih->id)
                                            <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File (Format: xlsx)</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" id="btn-template-dokumen"
                                style="color: white">Template
                                Dokumen</button>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btnDetailData', function() {
                var id = $(this).data('id'); // Ambil ID dari atribut data-id
                $('#remedial_ajuan_id').val(id);
                var buktiPembayaran = $(this).data('bukti'); // Ambil ID dari atribut data-id

                $.ajax({
                    url: '{{ url('/remedial/ajuan/detail') }}/' + id,
                    type: 'GET',
                    success: function(response) {
                        // Isi modal dengan data dari response
                        $('#modalDetailData #modalDetailDataLabel').text(
                            'Detail Ajuan Remedial');
                        var tbody = $('#modalDetailData #tabelData tbody');
                        var totalBayar = 0;
                        tbody.empty(); // Kosongkan tbody
                        $.each(response, function(index, item) {
                            totalBayar += parseFloat(item.harga_remedial);
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
                                '<td>' + formatRupiah(item.harga_remedial) +
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

                if (confirm('Apakah Anda yakin ingin menyetujui data ajuan remedial ini?')) {
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

            $('#btn-upload-rekor').on('click', function() {
                $('#modalUploadRakor').modal('show');
            });

        });


        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        document.getElementById("btn-template-dokumen").addEventListener("click", function() {
            window.location.href = "{{ route('export.downloadTemplateRekor') }}";
        });
    </script>
@endsection
