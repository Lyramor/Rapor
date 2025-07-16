@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('sisipan.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Ajuan Sisipan</h3>
                        <p>Detail Ajuan Sisipan</p>
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
                                    <a href="{{ route('sisipan.ajuan.daftarAjuan') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>

                                    <button class="btn btn-danger" type="button" id="btnBatalkanAjuan">Batalkan</button>
                                    @if (
                                        \Carbon\Carbon::now()->gte($data->sisipanperiode->tanggal_mulai) &&
                                            \Carbon\Carbon::now()->lte($data->sisipanperiode->tanggal_selesai) &&
                                            $data->sisipanperiode->is_aktif)
                                        <button class="btn btn-warning" type="button" id="btnSinkronData">
                                            Sinkron KRS
                                        </button>

                                        <button class="btn btn-primary" type="button" id="btnTambahData">
                                            Tambah Ajuan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('sisipan.ajuan.detail.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">

                                @if (
                                    \Carbon\Carbon::now()->gte($data->sisipanperiode->tanggal_mulai) &&
                                        \Carbon\Carbon::now()->lte($data->sisipanperiode->tanggal_selesai) &&
                                        $data->sisipanperiode->is_aktif)
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                        style="padding-bottom:0px">
                                        <p>
                                            <strong>Periode {{ $data->sisipanperiode->nama_periode }} telah berakhir.
                                            </strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </p>

                                    </div>
                                @endif



                                <div class="alert alert-info" role="alert" style="padding-bottom:0px">
                                    <p>
                                        <strong> Cek kembali kesesuaian Dosen Pengampu dengan Jadwal Kelas Perkuliahan
                                            di
                                            SITU2, khususnya untuk jadwal yang terdapat beberapa dosen. </strong>
                                    </p>
                                </div>
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            NIM</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->mahasiswa->nim }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Nama</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->mahasiswa->nama }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Program Studi</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->mahasiswa->programstudi }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Tahun Masuk</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->mahasiswa->periodemasuk }}</span>
                                    </div>
                                </div>
                                <!-- keterangan -->
                                <div class="card">
                                    <div class="card-body" style="display: flex">
                                        <div class="col-md-12">
                                            <div class="table-container">
                                                <table class="table table-hover" id="editableTable">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                No.
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Kode MK
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nama Matakuliah
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                SKS
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Kelas
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Dosen
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Nilai Angka
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Grade
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @if (count($data->sisipanajuandetail) == 0)
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($data->sisipanajuandetail as $item)
                                                                <tr class="text-center">
                                                                    <td hidden>{{ $item->id }}</td>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $item->idmk }}</td>
                                                                    <td>{{ $item->kelasKuliah->namamk }}</td>
                                                                    <td>{{ $item->krs->sksmk }}</td>
                                                                    <td>{{ $item->namakelas }}</td>
                                                                    <td>{{ $item->kelasKuliah->namadosen }}</td>
                                                                    <td>{{ $item->krs->nnumerik }}</td>
                                                                    <td>{{ $item->krs->nhuruf }}</td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger delete"
                                                                            title="Batalkan Ajuan">
                                                                            <i class="fas fa-trash-alt fa-xs"></i>
                                                                        </button>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Data -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Ajuan Sisipan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formTambahData" action="{{ route('sisipan.ajuan.detail.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row" style="">
                            <p><strong>
                                    Pastikan sudah melakukan sinkronasi terlebih dahulu, untuk mendapatkan nilai yang
                                    terbaru!

                                </strong></p>

                        </div>
                        <table class="table
                            table-bordered" id="tabelData">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Periode KRS</th>
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
                                        <td colspan="12" class="text-center">Tidak ada data</td>
                                    </tr>
                                @else
                                    @foreach ($data_krs as $item)
                                        <tr>
                                            @if ($item->kelasKuliah == null)
                                            @else
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->idperiode }}</td>
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
                                            @endif

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
                        <input type="text" name="periode" value="{{ $data->sisipanperiode->kode_periode }}" hidden>
                        <input type="text" name="nim" value="{{ $data->nim }}" hidden>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Sinkron</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Tampilkan modal saat tombol "Tambah Soal" ditekan
            $('#btnTambahSoal').click(function() {
                $('#modalTambahData').modal('show');
            });

            // Tampilkan modal sinkron data
            $('#btnSinkronData').click(function() {
                $('#modalSinkronData').modal('show');
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

            $('#btnTambahData').click(function() {
                $('#modalTambahData').modal('show');
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
                var jumlahSKS = [];

                $.each(formDataArray, function(index, element) {
                    if (element.name === 'data[]') {
                        dataTerpilih.push(element.value);
                        var row = $('input[value="' + element.value + '"]').closest('tr');
                        idmkTerpilih.push(row.find('td:eq(2)').text().trim());
                        namaKelasTerpilih.push(row.find('td:eq(5)').text().trim());
                        nipTerpilih.push(row.find('td:eq(6)').text().trim());
                        jumlahSKS.push(row.find('td:eq(4)').text().trim());
                    }
                });

                var totalJumlahSKS = jumlahSKS.reduce((a, b) => parseInt(a) + parseInt(b), 0);

                if (totalJumlahSKS > {{ $periodeTerpilih->sisipanperiodeprodi->first()->batas_sks }}) {
                    alert(
                        'Batas SKS yang diperbolehkan adalah {{ $periodeTerpilih->sisipanperiodeprodi->first()->batas_sks }} SKS. Jumlah SKS yang diajukan melebihi batas.'
                    );
                    return;
                }

                if (dataTerpilih.length === 0) {
                    alert('Tidak ada data yang terpilih. Silakan pilih data terlebih dahulu.');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin mengajukan data sisipan ini?')) {
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
                            sisipan_ajuan_id: '{{ $data->id }}',
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

            // Hapus baris tabel
            $('#editableTable').on('click', '.delete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                    var row = $(this).closest('tr');
                    var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                    // Kirim permintaan penghapusan ke server menggunakan Ajax
                    $.ajax({
                        type: "DELETE",
                        url: "/sisipan/ajuan/detail/" + id,
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

            // Batalkan ajuan
            $('#btnBatalkanAjuan').click(function() {
                if (confirm('Apakah Anda yakin ingin membatalkan ajuan ini?')) {
                    $.ajax({
                        type: "DELETE",
                        url: "/sisipan/ajuan/{{ $data->id }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            alert('Ajuan berhasil dibatalkan');
                            window.location.href = "{{ route('sisipan.ajuan.daftarAjuan') }}";
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });

        });
    </script>
@endsection
