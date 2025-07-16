@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .penilaian {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('navbar')
    @include('btq.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Kegiatan BTQ</h3>
                        <p>Dashboard</p>
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

        <div class="isi-konten">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Data Peserta</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="nip_peserta" class="col-form-label">NIM :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->username }}</p>
                                        {{-- <input type="text" id="nip_peserta" class="form-control" value=""> --}}
                                    </div>
                                    <div class="col-3">
                                        <label for="nama_peserta" class="col-form-label">Nama :</label>
                                    </div>
                                    <div class="col-9">
                                        <p class="card-text">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2" style="line-height: 0.7cm">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Tata Terbit Placement Test BTQ</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <ol>
                                            <li>Pada saat pelaksanaan Placement Test, wajib membawa Kitab Al-quran,
                                                tidak
                                                dalam bentuk digital
                                            </li>
                                            <li>Menggunakan pakaian yang baik dan sopan, untuk perempuan wajib
                                                menggunakan Kerudung</li>
                                            <li>Membawa Buku dan Alat Tulis</li>
                                            <li>Hadir 10 menit sebelum Jadwal yang telah dipilih</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Daftar Jadwal</h5>
                                </div>
                                <div class="col-4">
                                    {{-- button tambah jadwal --}}
                                    <div class="float-end">
                                        @if ($jadwal->isEmpty())
                                            <a href="{{ route('btq.jadwal.daftar-jadwal') }}" class="btn btn-primary">Pilih
                                                Jadwal</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">

                                {{-- jika data kuesioner kosong, maka tampilkan pesan --}}
                                @if ($jadwal->isEmpty())
                                    <div class="alert alert-info" role="alert">
                                        Belum ada jadwal yang tersedia
                                    </div>
                                @endif
                                @foreach ($jadwal as $item)
                                    <div class="penilaian">
                                        <div class="card-body">
                                            <h5 class="card-title" style="margin-bottom: 15px;">
                                                Jadwal Placement Test BTQ
                                            </h5>
                                            <hr>

                                            <div class="row align-items-center">
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Periode</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">{{ $item->jadwal->periode->nama_periode }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Penilaian</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <p class="card-text">Bacaan, Tulisan dan Hafalan Al-Qur'an
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Pementor</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">{{ $item->jadwal->penguji->name }}
                                                    </p>

                                                </div>

                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Jadwal</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="card-text">
                                                        {{ \Carbon\Carbon::parse($item->jadwal->jam_mulai)->isoFormat('hh:mm A') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($item->jadwal->jam_selesai)->isoFormat('hh:mm A') }}
                                                        ,
                                                        {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="status" class="create-label">
                                                        Status</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="card-text">
                                                        <span class="badge bg-success">{{ $item->jadwal->is_active }}</span>
                                                    </p>

                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <label for="nama_kuesioner" class="create-label">
                                                        Penilaian Mandiri</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($item->jadwal->is_active == 'Aktif')
                                                        <button type="button" class="btn btn-sm btn-warning btn-bacaan"
                                                            data-jadwal-mahasiswa-id="{{ $item->id }}">Bacaan</button>
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            data-jadwal-mahasiswa-id="{{ $item->id }}">Tulisan</button>
                                                        <button type="button" class="btn btn-sm btn-info"
                                                            data-jadwal-mahasiswa-id="{{ $item->id }}">Hafalan</button>
                                                    @else
                                                        <span class="badge bg-danger">Sudah tidak dapat diakses</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <h5>Mohon diperhatikan aturan berikut</h5>
                                                <ul>
                                                    <li>Anda hanya bisa memilih 1 Jadwal, maka pastikan tidak bentrok dengan
                                                        jadwal kelas dsb.</li>
                                                    <li>Untuk yang sudah mengambil jadwal namun tidak hadir, maka harus
                                                        mengulang ditahun depan.</li>
                                                    <li>Isi penilaiain mandiri setelah melakukan pemilihan jadwal</li>
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Lengkapi Profil Anda</h5>
                    <!-- Hapus tombol close -->
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    Jenis kelamin Anda belum terisi. Silakan lengkapi profil Anda terlebih dahulu.
                </div>
                <div class="modal-footer">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Ubah Profil</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPenilaian" tabindex="-1" aria-labelledby="modalPenilaianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenilaianLabel">Penilaian Hafalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Pastikan data yang diinputkan sudah sesuai. checklist bila "Ya" dan kosongkan bila "Tidak".
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <table class="table table-bordered" id="tabelData">
                        <thead>
                            <tr>
                                <th style="text-align: center;vertical-align: middle;">No.</th>
                                <th>Penilaian</th>
                                <th style="text-align: center;vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimasukkan secara dinamis melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanPenilaian">Simpan</button>
                </div>
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            @if ($showModal)
                // Tampilkan modal ketika halaman dimuat jika showModal true
                $('#profileModal').modal({
                    backdrop: 'static', // Cegah penutupan dengan klik di luar modal
                    keyboard: false // Cegah penutupan dengan tombol ESC
                });
                $('#profileModal').modal('show');
            @endif
        });

        // Klik tombol Bacaan, Tulisan, atau Hafalan
        $('.btn-warning, .btn-info, .btn-success').on('click', function() {
            // Ambil jenis penilaian dari tombol yang diklik
            var jenisPenilaian = $(this).text();

            // Ubah judul modal sesuai jenis penilaian
            $('#modalPenilaianLabel').text('Penilaian Mandiri ' + jenisPenilaian);

            // Tampilkan loading spinner
            $('#loadingSpinner').show();

            // Ambil jadwalMahasiswaId dari atribut data-jadwal-mahasiswa-id
            var jadwalMahasiswaId = $(this).data('jadwal-mahasiswa-id');

            // AJAX request untuk mendapatkan data penilaian
            $.ajax({
                url: "{{ route('btq.penilaian.get') }}",
                type: 'GET',
                data: {
                    jadwal_mahasiswa_id: jadwalMahasiswaId,
                    jenis_penilaian: jenisPenilaian
                },
                success: function(response) {
                    // Muat konten penilaian ke dalam tabel
                    var tbody = $('#tabelData tbody');
                    tbody.empty();

                    $.each(response.penilaian, function(index, penilaian) {
                        tbody.append(`
                        <tr>
                            <td style="text-align: center;vertical-align: middle;">${penilaian.btq_penilaian.no_urut}</td>
                            <td>${penilaian.btq_penilaian.text_penilaian_self}</td>
                            <td style="text-align: center;vertical-align: middle;">
                                <input type="checkbox" name="penilaian[]" value="${penilaian.id}" ${penilaian.nilai_self == 1 ? 'checked' : ''}>
                            </td>
                        </tr>
                    `);
                    });

                    // Sembunyikan loading spinner
                    $('#loadingSpinner').hide();

                    // Tampilkan modal penilaian
                    $('#modalPenilaian').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat memuat data penilaian ' + jenisPenilaian + '.',
                        'error'
                    );
                    $('#loadingSpinner').hide(); // Sembunyikan loading spinner jika error
                }
            });
        });

        // Simpan penilaian saat tombol simpan diklik
        $('#btnSimpanPenilaian').on('click', function() {
            var dataPenilaian = [];
            $('#tabelData input[type="checkbox"]').each(function() {
                var penilaianId = $(this).val();
                var nilai_self = $(this).is(':checked') ? 1 : 0;

                if (penilaianId) {
                    dataPenilaian.push({
                        id: penilaianId,
                        nilai_self: nilai_self
                    });
                }
            });

            // Kirim data penilaian yang dipilih ke backend
            $.ajax({
                url: "{{ route('btq.penilaian.self-assesment') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    penilaian: dataPenilaian,
                    penguji_id: "{{ Auth::user()->id }}"
                },
                success: function(response) {
                    Swal.fire(
                        'Berhasil!',
                        'Penilaian berhasil disimpan.',
                        'success'
                    ).then(() => {
                        $('#modalPenilaian').modal('hide');
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat menyimpan penilaian.',
                        'error'
                    );
                }
            });
        });
    </script>
@endsection
