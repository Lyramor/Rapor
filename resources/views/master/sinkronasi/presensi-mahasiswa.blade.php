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
                        <h3>Sinkronasi</h3>
                        <p>Data Mahasiswa</p>
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
                                    <a href="{{ route('master') }}" class="btn btn-secondary" type="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('master.sinkronasi.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <!-- Nama Indikator -->
                                <form>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="periodemasuk" class="create-label">
                                                Periode Akademik</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <select class="form-select" aria-label="Default select example"
                                                name="periodemasuk" required>
                                                <!-- <option value="">Periode Akademik</option> -->
                                                @foreach ($periode as $prd)
                                                    <option value="{{ $prd->kode_periode }}">{{ $prd->kode_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="nrpInput"
                                                name="nrp" placeholder="Masukkan NRP Mahasiswa">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        </div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="btnSinkronasi">
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                                <span class="sr-only">Loading...</span>
                                                Sinkronasi</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="hasilSinkronasi" class="create-label">
                                            Hasil </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" readonly id="hasilSinkronasi" name="hasilSinkronasi" cols="30" rows="5"></textarea>
                                    </div>
                                </div> -->
                                <!-- Ganti textarea hasilSinkronasi -->
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label class="create-label">Hasil</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <p id="pesanPresensi" class="fw-bold text-success mb-2"></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tabelHasilPresensi">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>Pertemuan</th>
                                                        <th>Hadir/Izin/Sakit</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- akan diisi oleh JavaScript -->
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
    <!-- Spinner Loading -->
    <div id="loadingSpinner" style="display: none;">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        // Menyimpan referensi ke elemen spinner saat halaman dimuat
        // Menyimpan referensi ke tombol sinkronasi
        var btnSinkronasi = document.getElementById('btnSinkronasi');
        var spinner = document.getElementById('btnSinkronasi').querySelector('.spinner-border');

        document.getElementById('btnSinkronasi').addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah submit form default

            const btn = this;
            const spinner = btn.querySelector('.spinner-border');
            const hasilTextarea = document.getElementById('hasilSinkronasi');

            // Tampilkan spinner dan disable tombol
            btn.disabled = true;
            spinner.classList.remove('d-none');
            btn.childNodes[2].textContent = ' Sinkronasi...';

            const form = btn.closest('form');
            const periode = form.elements['periodemasuk'].value;
            const nrp = document.getElementById('nrpInput').value;

            $.ajax({
                url: '{{ route('master.sinkronasi.getPresensiMahasiswa')}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    periode: periode,
                    nim: nrp
                },
                // success: function (response) {
                //     // hasilTextarea.value = response.message || 'Berhasil';
                //     // btn.disabled = false;
                //     // spinner.classList.add('d-none');
                //     // btn.childNodes[2].textContent = ' Sinkronasi';
                //     let output = response.message + '\n\n';
                //     if (response.data && Array.isArray(response.data)) {
                //         response.data.forEach((item, index) => {
                //             output += `#${index + 1}\n`;
                //             output += `Kode MK       : ${item.kode_mk}\n`;
                //             output += `Nama MK       : ${item.nama_mk}\n`;
                //             output += `Pertemuan     : ${item.hasil.total_pertemuan ?? 0}\n`;
                //             output += `Hadir/Izin/Sakit : ${item.hasil.hadir_sakit_izin ?? 0}\n`;
                //             output += `Persentase    : ${item.hasil.persentase ?? 0}%\n`;
                //             output += '\n';
                //         });
                //     }

                //     hasilTextarea.value = output;
                // },
                success: function (response) {
                    document.getElementById('pesanPresensi').textContent = response.message;
                    const tbody = document.querySelector('#tabelHasilPresensi tbody');
                    tbody.innerHTML = ''; // bersihkan isi lama

                    if (response.data && Array.isArray(response.data)) {
                        response.data.forEach((item, index) => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.kode_mk}</td>
                                <td>${item.nama_mk}</td>
                                <td>${item.hasil.total_pertemuan ?? 0}</td>
                                <td>${item.hasil.hadir_sakit_izin ?? 0}</td>
                                <td>${item.hasil.persentase ?? 0}%</td>
                            `;

                            tbody.appendChild(row);
                        });
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="6" class="text-center">Tidak ada data.</td>`;
                        tbody.appendChild(row);
                    }
                },

                error: function (xhr, status, error) {
                    let message = 'Terjadi kesalahan.';
                    try {
                        const res = JSON.parse(xhr.responseText);
                        message = res.error || status + ' : ' + error;
                    } catch (_) {}

                    hasilTextarea.value = message;
                },
                complete: function () {
                    btn.disabled = false;
                    spinner.classList.add('d-none');
                    btn.childNodes[2].textContent = ' Sinkronasi';
                }
            });
        });

    </script>
@endsection
