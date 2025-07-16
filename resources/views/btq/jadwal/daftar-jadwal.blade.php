@extends('layouts.main2')

@section('css-tambahan')
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
                        <h3>Baca Tulis Al-Quran</h3>
                        <p>Daftar Jadwal</p>
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

        {{-- <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <form id="formPeriode" action="{{ route('remedial.pelaksanaan.daftar-kelas') }}" method="GET">
                                @csrf
                                <div class="col-12" style="padding: 10px">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <label for="daftar_periode" class="col-form-label"><strong>Periode
                                                    Akademik</strong></label>
                                        </div>
                                        <div class="col-4">
                                            <select id="kode_periode" name="kode_periode" class="form-control required">
                                                <option value="">-- Pilih Periode --</option>
                                                @foreach ($daftar_periode as $item)
                                                    <option value="{{ $item->kode_periode }}">
                                                        {{ $item->nama_periode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
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
        </div> --}}

        <div class="" style="margin-top: 10px">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Daftar Jadwal Placement Test</h5>
                                </div>
                                <div class="col-12">
                                    <div class="">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <h5>Mohon diperhatikan aturan berikut</h5>
                                            <ul>
                                                <li>Anda hanya bisa memilih 1 Jadwal, maka pastikan tidak bentrok dengan
                                                    jadwal kelas dsb.</li>
                                                <li>Untuk yang sudah mengambil jadwal namun tidak hadir, maka harus
                                                    mengulang ditahun depan.</li>
                                                <li>Isi penilaiain mandiri setelah melakukan pemilihan jadwal</li>
                                            </ul>
                                        </div>
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
                                                No
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Jadwal Placement
                                            </th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Nama Pementor
                                            </th>
                                            <th>
                                                Sisa Kuota
                                            </th>
                                            <th>Tempat</th>
                                            <th style="text-align: center;vertical-align: middle;">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-body" class="text-center">
                                        @if ($data->count() > 0)
                                            @foreach ($data as $kelas)
                                                <tr style="text-align: center;vertical-align: middle;">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($kelas->jam_mulai)->isoFormat('hh:mm A') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($kelas->jam_selesai)->isoFormat('hh:mm A') }}
                                                        ,
                                                        {{ \Carbon\Carbon::parse($kelas->tanggal)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                                    </td>
                                                    <td>{{ $kelas->penguji->name }}</td>
                                                    <td>{{ $kelas->kuota - $kelas->jumlahMahasiswaTerdaftar() }}</td>
                                                    <td>{{ $kelas->ruang }}</td>
                                                    <td>
                                                        {{-- <form action="{{ route('btq.jadwal.store-mahasiswa') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="jadwal_id"
                                                                value="{{ $kelas->id }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">Pilih
                                                                Jadwal</button>
                                                        </form> --}}
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            onclick="confirmPilihJadwal('{{ $kelas->id }}')">Pilih
                                                            Jadwal</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">Tidak ada data.</td>
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
@endsection

@section('js-tambahan')
    <script>
        function confirmPilihJadwal(jadwalId) {
            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan memilih jadwal ini. Pilihan tidak dapat diubah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pilih Jadwal!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, jalankan AJAX untuk memilih jadwal
                    submitJadwalAJAX(jadwalId);
                }
            });
        }

        function submitJadwalAJAX(jadwalId) {
            const token = '{{ csrf_token() }}';

            let formData = new FormData();
            formData.append('jadwal_id', jadwalId);

            fetch('{{ route('btq.jadwal.store-mahasiswa') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan SweetAlert jika berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => {
                            // Jika ada perubahan di UI, Anda bisa lakukan di sini
                            location.reload(); // Misalnya reload halaman setelah sukses
                            // redirect to btq
                            window.location.href = '{{ route('btq') }}';
                        });
                    } else {
                        // Tampilkan SweetAlert jika terjadi kesalahan atau kuota penuh
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal mengirim data. Silakan coba lagi.',
                    });
                });
        }
    </script>
@endsection
