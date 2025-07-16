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
            /* float: left; */
            /* width: 250px; */
            /* Atur lebar kartu sesuai keinginan */
            margin-right: 10px;
        }

        #loadingSpinner {
            position: fixed;
            top: 50%;
            left: 50%;
            /* transform: translate(-50%, -50%); */
            z-index: 9999;
        }
    </style>
@endsection

@section('navbar')
    @include('remedial.mahasiswa.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Beranda</h3>
                        <p>Selamat Datang di Modul Remedial</p>
                    </span>
                </div>
            </div>
        </div>

        {{-- tampilkan message session success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-11">
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
                            <form id="formPeriode" action="{{ route('remedial.mahasiswa') }}" method="GET">
                                @csrf
                                <div class="col-12" style="padding: 10px">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <label for="inputPassword6" class="col-form-label"><strong>Periode
                                                    Remedial</strong></label>
                                        </div>
                                        <div class="col-5">
                                            <select id="periode-dropdown" class="form-select"
                                                aria-label="Default select example" name="periodeTerpilih">
                                                <option value="{{ $periodeTerpilih->kode_periode }}">
                                                    {{ $periodeTerpilih->nama_periode }}</option>
                                                @foreach ($daftar_periode as $periode)
                                                    @if ($periode->kode_periode != $periodeTerpilih->kode_periode)
                                                        <option value="{{ $periode->kode_periode }}">
                                                            {{ $periode->nama_periode }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <div class="pull-right">
                                                <button id="btn-cari-filter" style="width: 100px; color:white"
                                                    class="btn btn-primary" type="submit">Cari</button>
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

        <div class="" style="margin-top: 10px">
            <div class="row justify-content-md-center">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Daftar Ajuan Remedial</h5>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        @if (
                                            $data_ajuan->count() == 0 &&
                                                \Carbon\Carbon::now()->gte($periodeTerpilih->tanggal_mulai) &&
                                                \Carbon\Carbon::now()->lte($periodeTerpilih->tanggal_selesai) &&
                                                $periodeTerpilih->is_aktif)

                                                <!-- $data_ajuan->count() == 0 &&
                                                \Carbon\Carbon::now()->gte($periodeTerpilih->tanggal_mulai) &&
                                                \Carbon\Carbon::now()->lte($periodeTerpilih->tanggal_selesai) &&
                                                $periodeTerpilih->is_aktif) -->
                                            <button class="btn btn-warning" type="button" id="btnSinkronData">
                                                Sinkron KRS
                                            </button>

                                            <button class="btn btn-success" type="button" id="btnTambahData">
                                                Tambah Ajuan
                                            </button>
                                        @endif
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
                                                No.
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Tanggal Pengajuan
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nomor VA
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Total Bayar
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-body" class="text-center">
                                        @foreach ($data_ajuan as $ajuan)
                                            <tr>
                                                <td hidden>{{ $ajuan->id }}</td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ajuan->tgl_pengajuan }}</td>
                                                <td>{{ $ajuan->va }}</td>
                                                <td>Rp. {{ number_format($ajuan->total_bayar, 0, ',', '.') }}</td>
                                                <td>{{ $ajuan->status_pembayaran }}
                                                    <br>
                                                    @if ($ajuan->bukti_pembayaran)
                                                        <a href="{{ asset('storage/' . $ajuan->bukti_pembayaran) }}"
                                                            target="_blank">Bukti Pembayaran</a>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($ajuan->is_lunas == false)
                                                        <div class="d-grid gap 2 d-md-flex justify-content-md-center">
                                                        @if (
                                                            \Carbon\Carbon::now()->gte($periodeTerpilih->tanggal_mulai) &&
                                                            \Carbon\Carbon::now()->lte($periodeTerpilih->tanggal_selesai) &&
                                                            $periodeTerpilih->is_aktif)
                                                            <button type="button" class="btn btn-sm btn-warning edit"
                                                                id="btnUnggahData">
                                                                <i class="fas fa-upload fa-xs"
                                                                    title="Unggah Bukti Bayar"></i>
                                                            </button>
                                                            &nbsp;
                                                            <button type="button" class="btn btn-sm btn-danger delete"
                                                                title="Batalkan Ajuan">
                                                                <i class="fas fa-trash-alt fa-xs"></i>
                                                            </button>
                                                        @else
                                                            <!-- text pembayaran sudah ditutup -->
                                                            <span class="badge bg-danger">Pembayaran Ditutup</span>
                                                        @endif
                                                            
                                                            
                                                        </div>
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <details open="">
                                                        <summary style="text-align: left">Lihat Detail</summary>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Kode</th>
                                                                    <th>Matakuliah</th>
                                                                    <th>Nama Kelas</th>
                                                                    <th>Dosen</th>
                                                                    <th>Harga Remedial</th>
                                                                    <th>Status Kelas</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($ajuan->remedialajuandetail as $detail)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $detail->idmk }}</td>
                                                                        <td>{{ $detail->kelasKuliah->namamk }}</td>
                                                                        <td>{{ $detail->namakelas }}</td>
                                                                        <td>{{ $detail->kelasKuliah->namadosen }}</td>
                                                                        <td>Rp.
                                                                            {{ number_format($detail->harga_remedial, 0, ',', '.') }}
                                                                        </td>
                                                                        @if ($detail->status_ajuan == 'Diterima')
                                                                            <td><span
                                                                                    class="badge bg-success">Diadakan</span>
                                                                            </td>
                                                                        @elseif ($detail->status_ajuan == 'Dibatalkan')
                                                                            <td><span
                                                                                    class="badge bg-danger">{{ $detail->status_ajuan }}</span>
                                                                            </td>
                                                                        @else
                                                                            <td><span
                                                                                    class="badge bg-warning">{{ $detail->status_ajuan }}</span>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </details>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Informasi Remedial</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1"
                                    style="min-width: 125px;">Pendaftaran</span>
                                @php
                                    $tanggal_mulai = strftime('%d %B %Y', strtotime($periodeTerpilih->tanggal_mulai));
                                    $tanggal_selesai = strftime(
                                        '%d %B %Y',
                                        strtotime($periodeTerpilih->tanggal_selesai),
                                    );
                                @endphp

                                <input type="text" class="form-control"
                                    value="{{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}"
                                    aria-describedby="basic-addon1" readonly>
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1" style="min-width: 125px;">Biaya</span>
                                <input type="text" class="form-control"
                                    value="Rp. {{ number_format($periodeTerpilih->remedialperiodetarif[0]->tarif, 0, ',', '.') }}"
                                    aria-describedby="basic-addon1" readonly>
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1" style="min-width: 125px;">Batas
                                    Nilai</span>
                                <input type="text" class="form-control"
                                    value="{{ $periodeTerpilih->remedialperiodeprodi[0]->nilai_batas }}"
                                    aria-describedby="basic-addon1" readonly>
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1" style="min-width: 125px;">Batas
                                    Presensi</span>
                                <input type="text" class="form-control"
                                    value="{{ $periodeTerpilih->remedialperiodeprodi[0]->presensi_batas }} %"
                                    aria-describedby="basic-addon1" readonly>
                            </div>

                            <!-- tampilkan informasi pendaftaran dan pembayaran yang melebihi batas waktu akan ditolak -->
                            
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Pendaftaran & Pembayaran Remedial yang melebihi dari tanggal yang ditentukan akan ditolak.
                                </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Tambah Data -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Ajuan Remedial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formTambahData" action="{{ route('remedial.ajuan.storeAjax') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Pastikan anda sudah melakukan sinkronasi terlebih dahulu, untuk pengecekan syarat dan nilai yang
                                terbaru!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        <table class="table table-bordered" id="tabelData">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode MK</th>
                                    <th>Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Kelas</th>
                                    <th>NIP</th>
                                    <th>Dosen</th>
                                    <th>Presensi</th>
                                    <th>Nilai Angka</th>
                                    <th>Grade</th>
                                    <th><input type="checkbox" id="checkAll"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data_krs) == 0)
                                    <tr>
                                        <td colspan="11" class="text-center">Tidak ada data</td>
                                    </tr>
                                @else
                                    @foreach ($data_krs as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->idmk }}</td>
                                            <td>{{ $item->namamk }}</td>
                                            <td>{{ $item->sksmk }}</td>
                                            <td>{{ $item->namakelas }}</td>
                                            <td>{{ $item->kelasKuliah->nip }}</td>
                                            <td>{{ $item->kelasKuliah->namadosen }}</td>
                                            <td>{{ $item->presensi }} %</td>
                                            <td>{{ $item->nnumerik }}</td>
                                            <td>{{ $item->nhuruf }}</td>
                                            <td><input class="form-check-input checkbox-data" type="checkbox"
                                                    name="data[]" value="{{ $item->id }}"></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal sinkronasi data --}}
    <div class="modal fade" id="modalSinkronData" tabindex="-1" aria-labelledby="modalSinkronDataLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sinkronasi Data KRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('master.sinkronasi.hitungPresensi') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="text-align: center">
                        <p>Apakah Anda yakin ingin melakukan sinkronasi data KRS?</p>
                        <input type="text" name="periode" value="{{ $periodeTerpilih->kode_periode }}" hidden>
                        <input type="text" name="nim" value="{{ Auth::user()->username }}" hidden>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Sinkron</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal untuk Unggah Bukti Pembayaran -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Unggah Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('remedial.ajuan.uploadBukti') }}" id="formUnggahData" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="remedial_ajuan_id" id="remedial_ajuan_id">
                        <div class="mb-3">
                            <label for="tgl_pembayaran" class="form-label">Tanggal Pembayaran</label>
                            <input type="datetime-local" class="form-control" id="tgl_pembayaran" name="tgl_pembayaran"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Pilih File Bukti Pembayaran (JPG, PNG : Max
                                1MB)</label>
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Tampilkan modal tambah responden
            $('#btnTambahData').click(function() {
                $('#modalTambahData').modal('show');
            });

            // Tampilkan modal sinkron data
            $('#btnSinkronData').click(function() {
                $('#modalSinkronData').modal('show');
            });

            $('#checkAll').change(function() {
                $('.checkbox-data').prop('checked', $(this).prop('checked'));
            });

            // Kirim form menggunakan AJAX saat form "Tambah Responden" disubmit
            $('#formTambahData').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                var formDataArray = form.serializeArray();
                var dataTerpilih = [];
                var idmkTerpilih = [];
                var namaKelasTerpilih = [];
                var nipTerpilih = [];

                $.each(formDataArray, function(index, element) {
                    if (element.name === 'data[]') {
                        dataTerpilih.push(element.value);
                        var row = $('input[value="' + element.value + '"]').closest('tr');
                        idmkTerpilih.push(row.find('td:eq(1)').text());
                        namaKelasTerpilih.push(row.find('td:eq(4)').text());
                        nipTerpilih.push(row.find('td:eq(5)').text());
                    }
                });

                if (dataTerpilih.length === 0) {
                    alert('Tidak ada data yang terpilih. Silakan pilih data terlebih dahulu.');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin mengajukan data remedial ini?')) {
                    $('#loadingSpinner').show();
                    $.ajax({
                        url: url,
                        method: method,
                        data: {
                            _token: '{{ csrf_token() }}',
                            krs: dataTerpilih,
                            idmk: idmkTerpilih,
                            nama_kelas: namaKelasTerpilih,
                            nip: nipTerpilih,
                            remedial_periode_id: '{{ $periodeTerpilih->id }}' // Menggunakan ID kuesioner SDM
                        },
                        success: function(response) {
                            // console.log(response);
                            alert('Data berhasil diajukan');
                            $('#loadingSpinner').hide();
                            $('#modalTambahData').modal('hide');

                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseText;
                            $('#loadingSpinner').hide();
                            alert('Terjadi kesalahan, silakan coba lagi.');
                            console.log(errorMessage);
                        }
                    });
                }
            });

            // Kirim form menggunakan AJAX saat form "Sinkron Data" disubmit
            $('#modalSinkronData form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                $('#loadingSpinner').show();

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        alert('Sinkronasi data KRS berhasil');
                        $('#loadingSpinner').hide();
                        $('#modalSinkronData').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
                        $('#loadingSpinner').hide();
                        alert('Terjadi kesalahan, silakan coba lagi.');
                        console.log(errorMessage);
                    }
                });
            });
        });

        $('#btnUnggahData').click(function() {
            const remedialAjuanId = $(this).closest('tr').find('td:first-child').text().trim();
            $('#remedial_ajuan_id').val(remedialAjuanId);
            $('#uploadModal').modal('show');
        });

        $('#formUnggahData').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = new FormData(form[0]);

            $('#loadingSpinner').show();

            $.ajax({
                url: url,
                method: method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Bukti pembayaran berhasil diunggah');
                    $('#loadingSpinner').hide();
                    $('#uploadModal').modal('hide');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText;
                    $('#loadingSpinner').hide();
                    alert('Terjadi kesalahan, silakan coba lagi.');
                    console.log(errorMessage);
                }
            });
        });

        // Hapus baris tabel
        $('#editableTable').on('click', '.delete', function() {
            if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: "DELETE",
                    url: "/remedial/ajuan/" + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        alert('Data berhasil dihapus');
                        // row.remove(); // Hapus baris dari tabel setelah berhasil dihapus
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            }
        });
    </script>
@endsection
