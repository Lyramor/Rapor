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
                        <h3>Remedial</h3>
                        <p>Daftar Periode Remedial</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        <div class="isi-konten" style="margin-top: 0px;">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">

                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <a href="{{ route('remedial.periode.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            Periode</a>
                                        {{-- <button class="btn btn-warning" style="color:#fff" id="btnSalin">Salin
                                            Periode</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-hover" id="editableTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Periode
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Nama Periode
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Fakultas
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">Tanggal Mulai</th>
                                                <th style="text-align: center;vertical-align: middle;">Tanggal Selesai</th>

                                                <th style="text-align: center;vertical-align: middle;">
                                                    Aktif
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            {{-- foreach untuk data rapor --}}
                                            @if (count($data) == 0)
                                                <tr>
                                                    <td colspan="7"
                                                        style="text-align: center;vertical-align:
                                                        middle;">
                                                        Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $periodeRemedial)
                                                    <tr style="text-align: center;vertical-align: middle;">
                                                        <td hidden>{{ $periodeRemedial->id }}</td>
                                                        <td>{{ $periodeRemedial->periode->nama_periode }}</td>
                                                        <td>{{ $periodeRemedial->nama_periode }}</td>
                                                        <td>{{ $periodeRemedial->unitkerja->nama_unit }}</td>
                                                        <td>{{ $periodeRemedial->tanggal_mulai }}</td>
                                                        <td>{{ $periodeRemedial->tanggal_selesai }}</td>
                                                        <td>
                                                            @if ($periodeRemedial->is_aktif)
                                                                <i class="fas fa-check-circle" style="color: green"></i>
                                                            @else
                                                                <i class="fas fa-times-circle" style="color: red"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('remedial.periode.edit', ['id' => $periodeRemedial->id]) }}"
                                                                class="btn btn-sm btn-warning edit">
                                                                <i class="fas fa-edit fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('remedial.periode.prodi', ['id' => $periodeRemedial->id]) }}"
                                                                class="btn btn-sm btn-info detail">
                                                                <i class="fas fa-link fa-xs"></i>
                                                            </a>
                                                            {{-- <button type="button" class="btn btn-sm btn-danger delete">
                                                                <i class="fas fa-trash-alt fa-xs"></i>
                                                            </button> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tambahkan container untuk pagination di bawah tabel -->
                                @include('komponen.pagination')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSalin" tabindex="-1" aria-labelledby="modalSalinLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSalinLabel">Salin Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSalinSoal" action="{{ route('remedial.periode.salin') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaKuesioner" class="form-label">Periode yang Disalin</label>
                            <select class="form-select" name="old_periode_id" id="old_periode_id" required>
                                <option value="">Pilih Periode lama</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="namaKuesioner" class="form-label">Periode</label>
                            <select class="form-select" name="kode_periode" id="kode_periode" required>
                                <option value="">Pilih Periode Remedial</option>
                                @foreach ($periode as $item)
                                    <option value="{{ $item->kode_periode }}">{{ $item->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unit_kerja_id" class="form-label">Fakultas Studi</label>

                            <select class="form-select" name="unit_kerja_id" id="unit_kerja_id" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach ($unitkerja as $unit)
                                    {{-- <option value="{{ $unit->id }}">{{ $unit->nama_unit }}
                                </option> --}}
                                    @if (!empty($unitkerja->childUnit))
                                        <option value="{{ $unit->id }}">
                                            {{ $unit->nama_unit }}</option>
                                    @endif
                                    @if (!empty($unit->childUnit))
                                        @foreach ($unit->childUnit as $child)
                                            <option value="{{ $child->id }}">&nbsp;&nbsp;
                                                {{ $child->nama_unit }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_periode" class="form-label">Nama Periode</label>
                            <input type="text" class="form-control" id="nama_periode" name="nama_periode" required>
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
        $('#btnSalin').click(function() {
            $('#modalSalin').modal('show');
        });

        $('#formSalinSoal').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]); // Menggunakan FormData untuk mengumpulkan data form

            // Tambahkan CSRF token secara manual ke FormData
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: url,
                method: 'POST',
                processData: false, // Tidak memproses data FormData secara otomatis
                contentType: false, // Tidak mengatur Content-Type secara otomatis
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#modalSalin').modal('hide'); // Menutup modal
                    // window.location.reload(); // Memuat ulang halaman setelah berhasil
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText;
                    console.error(errorMessage);
                    // Tambahkan penanganan kesalahan sesuai kebutuhan
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
                    url: "/remedial/periode/" + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        alert('Data berhasil dihapus');
                        row.remove(); // Hapus baris dari tabel setelah berhasil dihapus
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
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
