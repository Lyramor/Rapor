@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('master.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>User</h3>
                        <p>Daftar User</p>
                    </span>
                </div>
            </div>
        </div>

        {{-- Tampilkan message session success/error jika ada --}}
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
        <div class="isi-konten" style="margin-top: 0px;">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan NIP/Nama/Email">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        {{-- backbutton --}}
                                        <a href="{{ route('master') }}" class="btn btn-secondary" type="button">Kembali</a>
                                        {{-- addbutton --}}
                                        <a href="{{ route('master.role.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            User</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="editableTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Username
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Email
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-body">
                                        @foreach ($data as $user)
                                            <tr>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{ $user->username }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{ $user->name }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{ $user->email }}
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    {{-- <a href="{{ route('master.user.edit', $user->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a> --}}
                                                    {{-- detail button --}}
                                                    <a href="{{ route('master.user.detail', $user->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-link"></i>
                                                    </a>

                                                    <form action="{{ route('master.user.delete', $user->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Anda yakin ingin menghapus role ini?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
@endsection

@section('js-tambahan')
    <script>
        const btnCari2 = document.querySelector("#btn-cari-search");
        btnCari2.addEventListener("click", function() {
            var perPage = document.getElementById("perPage").value;
            searchData(perPage); // Memanggil searchData dengan parameter 1 untuk halaman pertama
        });

        function searchData(page) {
            const query = document.querySelector("input[name='query']").value;

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ route('getDataUser') }}",
                method: "GET",
                data: {
                    search: query,
                    page: page // Mengirimkan parameter page
                },
                success: function(response) {
                    updateTable(response);
                    updatePagination(response); // Memanggil fungsi updatePagination dengan response
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan, silakan coba lagi.");
                }
            });
        }

        function updateTable(response) {
            const tableBody = document.querySelector("#tabel-body");
            tableBody.innerHTML = "";

            const dataUser = response.data;

            if (dataUser.length === 0) {
                const emptyRow = document.createElement("tr");
                emptyRow.innerHTML = `
                <td colspan="4" class="text-center">Tidak ada data</td>
            `;
                tableBody.appendChild(emptyRow);
                return;
            }

            dataUser.forEach(function(user) {
                const newRow = document.createElement("tr");
                newRow.style.textAlign = "center";
                newRow.style.verticalAlign = "middle";

                newRow.innerHTML = `
                <td>${user.username}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <a href="/master/user/detail/${user.id}" class="btn btn-sm btn-info">
                        <i class="fas fa-link"></i>
                    </a>
                    <form action="/master/user/delete/${user.id}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus role ini?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            `;
                tableBody.appendChild(newRow);
            });
        }
    </script>

    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
