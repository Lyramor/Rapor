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

        <div class="isi-konten">
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
                                <table id="editableTable" class="table table-hover">
                                    <thead class="text-center">
                                        <th style="width: 5%">#</th>
                                        <th style="width: 40%">Indikator Kinerja</th>
                                        <th style="width: 10%">Bobot</th>
                                        <th style="width: 10%">Urutan</th>
                                        <th style="width: 10%">Jenis</th>
                                        <th style="width: 25%" class="text-center">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="text-center">
                                                <td scope="row" hidden>{{ $item->id }}</td>
                                                <td scope="row">{{ $loop->iteration }}</td>
                                                <td contenteditable="true">{{ $item->nama_indikator_kinerja }}</td>
                                                <td contenteditable="true">{{ $item->bobot }}</td>
                                                <td contenteditable="true">{{ $item->urutan }}</td>
                                                <td contenteditable="true">{{ $item->type_indikator }}</td>
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
        });
    </script>
@endsection
