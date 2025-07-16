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
                        <h3>Kuesioner SDM</h3>
                        <p>Detail Kegiatan Kuesioner</p>
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
                                    <a href="{{ route('sisipan.periode') }}" class="btn btn-secondary"
                                        type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Tambah Tarif</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('sisipan.periode.rules.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Periode</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $sisipanperiode->periode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Nama Periode</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $sisipanperiode->nama_periode }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Tanggal Mulai</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($sisipanperiode->tanggal_mulai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                        </span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Tanggal Selesai</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ \Carbon\Carbon::parse($sisipanperiode->tanggal_selesai)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                                        </span>
                                    </div>

                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Aktif</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">
                                            {{ $sisipanperiode->is_aktif == 1 ? 'Ya' : 'Tidak' }}
                                        </span>
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
                                                                Angkatan
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Tarif
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td hidden>{{ $item->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $item->periode_angkatan }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ 'Rp ' . number_format($item->tarif, 0, ',', '.') }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <button class="btn btn-danger delete">Hapus</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahData" action="{{ route('sisipan.periode.tarif.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="periode_angkatan" class="form-label">Periode Angkatan Mahasiswa</label>
                            <select class="form-select" id="periode_angkatan" name="periode_angkatan" required>
                                <option value="">Pilih Periode Angkatan Mahasiswa</option>
                                @foreach ($periode as $periode)
                                    <option value="{{ $periode->kode_periode }}">{{ $periode->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tarif" class="form-label">Tarif</label>
                            <input type="text" class="form-control" id="tarif" name="tarif" required>
                            <input type="text" class="form-control" id="idSisipanPeriode" name="idSisipanPeriode"
                                value="{{ $sisipanperiode->id }}" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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

            $('#formTambahData').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');

                // Ambil nilai asli tarif
                var tarif = $('#tarif').val().replace(/[Rp.]/g, '').trim();
                // Buat objek data yang akan dikirim
                var formData = {
                    _token: '{{ csrf_token() }}',
                    periode_angkatan: $('#periode_angkatan').val(),
                    tarif: tarif,
                    idSisipanPeriode: $('#idSisipanPeriode').val()
                };

                $.ajax({
                    url: url,
                    method: method,
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        console.log(response);
                        $('#modalTambahData').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText;
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
                        url: "/sisipan/periode/tarif/" + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus');
                            row.remove(); // Hapus baris dari tabel setelah berhasil dihapus
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });
        });

        document.getElementById('tarif').addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/[^,\d]/g, ''); // Hanya angka yang diizinkan
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Menambahkan titik sebagai pemisah ribuan
            e.target.value = value ? 'Rp ' + value : ''; // Menambahkan Rp di depan nilai
        });
    </script>
@endsection
