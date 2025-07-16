@extends('layouts.main')

@section('css-tambahan')
    <style>
        /* Style untuk menunjukkan elemen sedang diedit */
        .editable {
            background-color: #f3f3f3;
        }
    </style>
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="judul-modul">
                    <h3>Indikator Kinerja</h3>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <h5>Indikator Kinerja</h5> --}}
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <a href="{{ route('indikator-kinerja.create') }}" class="btn btn-success">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12 justify-content-md-center">
                                <table id="editableTable" class="table table-striped table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 40%">Indikator Kinerja</th>
                                            <th style="width: 10%">Bobot</th>
                                            <th style="width: 10%">Urutan</th>
                                            <th style="width: 10%">Jenis</th>
                                            <th style="width: 25%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Baris utama -->
                                        <tr class="text-center parent-row">
                                            <td scope="row" hidden>1</td>
                                            <td scope="row">1</td>
                                            <td contenteditable="true">Mark</td>
                                            <td contenteditable="true">15</td>
                                            <td contenteditable="true">1</td>
                                            <td contenteditable="true">Kuantitatif</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger delete">
                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary save">
                                                    <i class="fas fa-save fa-xs"></i>
                                                </button>
                                                <a href="#" class="btn btn-sm btn-info detail">
                                                    <i class="fas fa-link fa-xs"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Baris bersarang untuk baris 1 -->
                                        <tr class="nested-row">
                                            <td></td>
                                            <td colspan="5">
                                                <table class="table nested-table">
                                                    <tbody>
                                                        <tr class="text-center">
                                                            <td scope="row" hidden>1</td>
                                                            <td scope="row">1.1</td>
                                                            <td contenteditable="true">Sub-Mark 1</td>
                                                            <td contenteditable="true">10</td>
                                                            <td contenteditable="true">2</td>
                                                            <td contenteditable="true">Kualitatif</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-danger delete">
                                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-primary save">
                                                                    <i class="fas fa-save fa-xs"></i>
                                                                </button>
                                                                <!-- Tombol untuk baris bersarang tidak ada -->
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td scope="row" hidden>1</td>
                                                            <td scope="row">1.1</td>
                                                            <td contenteditable="true">Sub-Mark 1</td>
                                                            <td contenteditable="true">10</td>
                                                            <td contenteditable="true">2</td>
                                                            <td contenteditable="true">Kualitatif</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-danger delete">
                                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-primary save">
                                                                    <i class="fas fa-save fa-xs"></i>
                                                                </button>
                                                                <!-- Tombol untuk baris bersarang tidak ada -->
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td scope="row" hidden>1</td>
                                                            <td scope="row">1.1</td>
                                                            <td contenteditable="true">Sub-Mark 1</td>
                                                            <td contenteditable="true">10</td>
                                                            <td contenteditable="true">2</td>
                                                            <td contenteditable="true">Kualitatif</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-danger delete">
                                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-primary save">
                                                                    <i class="fas fa-save fa-xs"></i>
                                                                </button>
                                                                <!-- Tombol untuk baris bersarang tidak ada -->
                                                            </td>
                                                        </tr>
                                                        <!-- Baris-baris lainnya di dalam baris bersarang -->
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Baris utama berikutnya -->
                                        <!-- ... -->
                                        <!-- Baris bersarang untuk baris utama berikutnya -->
                                        <!-- ... -->
                                        <!-- Baris utama berikutnya -->
                                        <!-- ... -->
                                        <!-- Baris bersarang untuk baris utama berikutnya -->
                                        <!-- ... -->
                                        <!-- Dan seterusnya sampai 10 baris utama -->
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Simpan data setelah mengedit
            $('#editableTable').on('click', '.save', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                var nama_indikator_kinerja = row.find('td:eq(2)').text();
                var bobot = row.find('td:eq(3)').text();
                var urutan = row.find('td:eq(4)').text();
                var type_indikator = row.find('td:eq(5)').text();

                $.ajax({
                    type: "PUT",
                    url: "/rapor/indikator-kinerja/" + id,
                    data: {
                        nama_indikator_kinerja: nama_indikator_kinerja,
                        bobot: bobot,
                        urutan: urutan,
                        type_indikator: type_indikator,
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT'
                    },
                    success: function(response) {
                        alert('Data berhasil diupdate');
                        // Lakukan sesuatu setelah data berhasil diupdate
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
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
                        url: "/rapor/indikator-kinerja/" + id,
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

            // Sembunyikan semua baris bersarang saat halaman dimuat
            $('.nested-row').hide();

            // Tambahkan event click pada baris parent untuk menampilkan atau menyembunyikan baris bersarang
            $('.parent-row').click(function() {
                $(this).next('.nested-row').toggle();
            });

            // Tambahkan event click pada tombol delete di baris parent
            $('.parent-row .delete').click(function(event) {
                event.stopPropagation(); // Mencegah event click pada baris parent yang diaktifkan juga
                // Logika penghapusan baris parent
            });

            // Tambahkan event click pada tombol save di baris parent
            $('.parent-row .save').click(function(event) {
                event.stopPropagation(); // Mencegah event click pada baris parent yang diaktifkan juga
                // Logika penyimpanan perubahan pada baris parent
            });

            // Tambahkan event click pada tombol detail di baris parent
            $('.parent-row .detail').click(function(event) {
                event.stopPropagation(); // Mencegah event click pada baris parent yang diaktifkan juga
                // Logika untuk menampilkan detail atau melakukan aksi lainnya pada baris parent
            });

            // Tambahkan event click pada tombol delete di baris bersarang
            $('.nested-row .delete').click(function(event) {
                event.stopPropagation(); // Mencegah event click pada baris parent yang diaktifkan juga
                // Logika penghapusan baris bersarang
            });

            // Tambahkan event click pada tombol save di baris bersarang
            $('.nested-row .save').click(function(event) {
                event.stopPropagation(); // Mencegah event click pada baris parent yang diaktifkan juga
                // Logika penyimpanan perubahan pada baris bersarang
            });
        });
    </script>
@endsection
