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
                        <p>Presensi</p>
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
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" id="btnGetToken">Get Token</button>
                                    </div>
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
                                            <label for="tokenTextarea" class="create-label">
                                                Token</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" readonly id="tokenTextarea" name="access_token" cols="30" rows="5">{{ session('token_sevima') ? session('token_sevima') : '' }}
                                        </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="programstudi" class="create-label">
                                                Program Studi</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <select class="form-select" aria-label="Default select example"
                                                name="programstudi" required>
                                                <option value="">Pilih Program Studi</option>
                                                @foreach ($programstudi as $prodi)
                                                    <option value="{{ urlencode($prodi->nama) }}">{{ $prodi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <select class="form-select" aria-label="Default select example"
                                                name="periodeakademik" required>
                                                <option value="">Periode Akademik</option>
                                                @foreach ($periode as $prd)
                                                    <option value="{{ $prd->kode_periode }}">{{ $prd->kode_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                            <label for="tokenTextarea" class="create-label">
                                                Limit </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="limit" name="limit"
                                                placeholder="Masukkan Jumlah Data" value="10">
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

                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label" style="margin-bottom: 10px;">
                                        <label for="hasilSinkronasi" class="create-label">
                                            Hasil </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" readonly id="hasilSinkronasi" name="hasilSinkronasi" cols="30" rows="5"></textarea>
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

        document.getElementById('btnGetToken').addEventListener('click', function() {
            $.ajax({
                url: '{{ route('master.sinkronasi.getToken') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.access_token) {
                        // Perbarui isi textarea dengan token yang diterima
                        document.getElementById('tokenTextarea').value = response.access_token;
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error: ' + error);
                }
            });
        });

        document.getElementById('btnSinkronasi').addEventListener('click', function() {

            btnSinkronasi.disabled = true;
            spinner.classList.remove('d-none');
            this.textContent = 'Loading...';
            var form = this.closest('form'); // Mendapatkan form terdekat dari tombol yang diklik
            var programstudi = form.elements['programstudi'].options[form.elements['programstudi'].selectedIndex]
                .innerText;

            $.ajax({
                url: '{{ route('master.sinkronasi.getDataKelasKuliah') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    access_token: document.getElementById('tokenTextarea').value,
                    programstudi: programstudi,
                    periodeakademik: document.querySelector('select[name="periodeakademik"]').value,
                    limit: encodeURIComponent(document.getElementById('limit').value)
                },
                success: function(response) {
                    if (response.success) {
                        // Perbarui isi textarea dengan token yang diterima
                        document.getElementById('hasilSinkronasi').value = response.message;
                    } else {
                        document.getElementById('hasilSinkronasi').value = response.message;
                    }
                    // Aktifkan kembali tombol sinkronasi
                    btnSinkronasi.disabled = false;
                    // Sematkan kembali teks asli tombol sinkronasi
                    document.getElementById('btnSinkronasi').textContent = 'Sinkronasi';

                    // Sembunyikan spinner di dalam tombol
                    spinner.classList.add('d-none');
                },
                error: function(xhr, status, error) {
                    var errorResponse = JSON.parse(xhr.responseText);
                    var errorMessage = JSON.parse(errorResponse.error.split('\n')[1]).error_message;
                    document.getElementById('hasilSinkronasi').value = status + " : " + errorMessage;
                    // alert('AJAX Error: ' + error);
                    // Aktifkan kembali tombol sinkronasi
                    btnSinkronasi.disabled = false;

                    // Sematkan kembali teks asli tombol sinkronasi
                    document.getElementById('btnSinkronasi').textContent = 'Sinkronasi';

                    // Sembunyikan spinner di dalam tombol
                    spinner.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
