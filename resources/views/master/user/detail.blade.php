@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('master.navbar')
@endsection


@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>User</h3>
                        <p>Detail User</p>
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

        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    {{-- <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan Judul Soal">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div> --}}
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="/master/user" class="btn btn-secondary" type="button">Kembali</a>
                                    {{-- button reset password --}}
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalResetPassword">
                                        Reset Password
                                    </button>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnTambahSoal">Tambah Role</button>
                                    </div>

                                    {{-- <a href="{{ route('kuesioner.banksoal.create-pertanyaan', ['id' => $data->id]) }}"
                                            class="btn btn-primary" style="color:#fff">Tambah
                                        </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('master.user.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            NIP</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->username }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Nama</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->name }}</span>
                                    </div>
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Email</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->email }}</span>
                                    </div>
                                    {{-- <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="nama_kuesioner" class=" create-label">
                                            Akun Pegawai</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="input-group-text">{{ $data->pegawai->nama }}</span>
                                    </div> --}}
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
                                                                Nama Role
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Unit Kerja
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @foreach ($roleuser as $role)
                                                            <tr>
                                                                <td hidden><input type="hidden" name="roleUserid"
                                                                        value="{{ $role->id }}"></td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $role->role->name }}
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    @if ($role->unitkerja)
                                                                        {{ $role->unitkerja->nama_unit }}
                                                                    @else
                                                                        Tidak ada unit kerja
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger delete">
                                                                        <i class="fas fa-trash-alt fa-xs"></i>
                                                                    </button>
                                                                </td>
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
    <!-- Modal Tambah Soal -->
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahSoal" action="{{ route('master.roleuser.create') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" id="user_id" name="user_id" value="{{ $data->id }}">
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Pilih Role User</option>
                                @foreach ($listrole as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" id="unit_kerja_id" name="unit_kerja_id" required>
                                <option value="">Pilih Unit Kerja User</option>
                                @foreach ($unitkerja as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_unit }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Reset Password -->
    <div class="modal fade" id="modalResetPassword" tabindex="-1" aria-labelledby="modalResetPasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResetPasswordLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formResetPassword" action="{{ route('master.user.reset-password') }}" method="POST">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" value="{{ $data->id }}">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mereset password user ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $('#btnTambahSoal').click(function() {
            $('#modalTambahSoal').modal('show');
        });

        // Kirim form menggunakan AJAX saat form "Tambah Soal" disubmit
        $('#formTambahSoal').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();

            // Buat objek data yang akan dikirim
            var formData = {
                _token: '{{ csrf_token() }}',
                user_id: $('#user_id').val(),
                role_id: $('#role_id').val(),
                unit_kerja_id: $('#unit_kerja_id').val(),
                // tambahkan data lain sesuai kebutuhan
            };

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    console.log(response);
                    $('#modalTambahSoal').modal('hide');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText;
                    console.log(errorMessage);
                }
            });
        });

        // btnresetpasswor
        $('#btnResetPassword').click(function() {
            $('#modalResetPassword').modal('show');
        });

        // Kirim form menggunakan AJAX saat form "Reset Password" disubmit
        $('#formResetPassword').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();

            // Buat objek data yang akan dikirim
            var formData = {
                _token: '{{ csrf_token() }}',
                user_id: $('#user_id').val(),
                // tambahkan data lain sesuai kebutuhan
            };

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    console.log(response);
                    alert('Password berhasil direset');
                    $('#modalResetPassword').modal('hide');
                    // window.location.reload();
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
                var id = row.find('input[name="roleUserid"]').val();
                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: "DELETE",
                    url: "/master/roleuser/" + id,
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
    </script>
@endsection
