@extends('layouts.ujian')

@section('css-tambahan')
    <style>
        .pertanyaan {
            text-align: justify;
            margin-left: -20px;
            margin-bottom: 20px;
            margin-right: 20px;
            display: none;
            font-size: 15px;
        }

        .rating-form label {
            /* margin-right: 10px; */
        }

        .rating-form input[type="radio"] {
            margin: 0 5px;
        }

        .btn-soal {
            display: inline-block;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #333;
            margin-right: 5px;
            /* Menambahkan jarak antara tombol */
            margin-top: 5px;
            /* Menambahkan jarak antara baris */
            width: 40px;
            height: 40px;
            font-size: 15px;
            padding: 7px;
            text-align: center;
        }

        .btn-soal:hover {
            background-color: #f0f0f0;
        }

        .list-unstyled {
            float: left;
        }

        .btn-soal-terisi {
            background-color: #0d6efd;
            color: white;
        }
    </style>
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul" style="margin-bottom: 20px">
                    <span>
                        <h3>{{ $data->kuesionerSDM->nama_kuesioner }}</h3>
                        {{-- <p>Penilaian</p> --}}
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
                <div class="col-9">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Penilaian {{ $data->kuesionerSDM->jenis_kuesioner }} :
                                        {{ $data->kuesionerSDM->pegawai->nama }} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <form id="form-penilaian" action="{{ route('kuesioner.penilaian.store') }}" method="POST">
                                    @csrf
                                    <ol>
                                        {{-- responden id  hidden --}}
                                        <input type="hidden" name="responden_id" value="{{ $data->id }}">
                                        <input type="hidden" name="kuesioner_sdm_id" value="{{ $data->kuesioner_sdm_id }}">
                                        @foreach ($data->penilaian as $penilaian)
                                            <div class="pertanyaan" data-pertanyaan="{{ $penilaian->pertanyaan->id }}">
                                                {{-- tampilkan count iteration --}}
                                                <span style="">
                                                    <p><strong>Penilaian ke-{{ $loop->iteration }} </strong></p>
                                                </span>
                                                <div class="mb-3">
                                                    {!! htmlspecialchars_decode($penilaian->pertanyaan->pertanyaan) !!}
                                                </div>

                                                <div class="mb-3">
                                                    {{-- <label for="jawaban" class="form-label">Jawaban : </label> --}}

                                                    @if ($penilaian->pertanyaan->jenis_pertanyaan == 'range_nilai')
                                                        <div class="rating-form" action="">
                                                            <label for=""
                                                                style="margin-right: 50px">{{ $penilaian->pertanyaan->scale_text_min }}</label>
                                                            @for ($i = $penilaian->pertanyaan->scale_range_min; $i <= $penilaian->pertanyaan->scale_range_max; $i++)
                                                                <input type="radio"
                                                                    name="{{ $penilaian->pertanyaan->id }}"
                                                                    value="{{ $i }}">
                                                                {{ $i }}
                                                            @endfor
                                                            <label for=""
                                                                style="margin-left: 50px">{{ $penilaian->pertanyaan->scale_text_max }}</label>
                                                        </div>
                                                    @else
                                                        <textarea class="form-control" name="{{ $penilaian->pertanyaan->id }}" rows="3"></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </ol>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Daftar Pertanyaan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="">
                            <div class="col-md-12" style="text-align: center">
                                <ul class="list-unstyled">
                                    {{-- dummy data 10 --}}
                                    {{-- @for ($i = 1; $i <= 10; $i++)
                                        <li style="float: left">
                                            <a href="#" class="btn-soal" data-pertanyaan="{{ $i }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor --}}
                                    @foreach ($data->penilaian as $index => $penilaian)
                                        <li style="float: left">
                                            <a href="#" class="btn-soal"
                                                data-pertanyaan="{{ $penilaian->pertanyaan->id }}">
                                                {{ $index + 1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div style="clear: both"></div>
                                <!-- Tombol Submit -->
                                <button type="submit" class="btn btn-primary" form="form-penilaian" id="btn-selesai" disabled>
    Selesai Penilaian
</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Konten Modal akan dimasukkan oleh JavaScript -->
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            const btnSoal = $('.btn-soal');
            const pertanyaan = document.querySelectorAll('.pertanyaan');

            pertanyaan[0].style.display = 'block';

            // Fungsi untuk memeriksa nilai input dan mengubah warna tombol soal
            function checkAndChangeColor(input, tombolSoal) {
                if (input.type === 'textarea') {
                    if (input.value.trim() !== '') {
                        tombolSoal.addClass('btn-soal-terisi');
                    } else {
                        tombolSoal.removeClass('btn-soal-terisi');
                    }
                } else if (input.type === 'radio') {
                    const checkedRadio = document.querySelector('input[name="' + input.name + '"]:checked');
                    if (checkedRadio) {
                        tombolSoal.addClass('btn-soal-terisi');
                    } else {
                        tombolSoal.removeClass('btn-soal-terisi');
                    }
                }
            }

            // Event handler untuk tombol soal
            btnSoal.on('click', function(e) {
                e.preventDefault();
                const pertanyaanID = $(this).data('pertanyaan');
                const pertanyaan = $('.pertanyaan[data-pertanyaan="' + pertanyaanID + '"]');

                // Tampilkan pertanyaan yang sesuai
                $('.pertanyaan').hide();
                pertanyaan.show();
            });

            // Memanggil fungsi checkAndChangeColor() saat input radio berubah
            $('input[type="radio"]').on('change', function() {
                const pertanyaanID = $(this).attr('name');
                const tombolSoal = $('.btn-soal[data-pertanyaan="' + pertanyaanID + '"]');
                checkAndChangeColor(this, tombolSoal);
            });

            // Memanggil fungsi checkAndChangeColor() saat textarea berubah
            $('textarea').on('input', function() {
                const pertanyaanID = $(this).attr('name');
                const tombolSoal = $('.btn-soal[data-pertanyaan="' + pertanyaanID + '"]');
                checkAndChangeColor(this, tombolSoal);
            });


            // Event handler untuk tombol submit
            $('#form-penilaian').on('submit', function(e) {
                e.preventDefault();

                const totalSoal = $('.btn-soal').length;
                const terisi = $('.btn-soal.btn-soal-terisi').length;
                const belumTerisi = totalSoal - terisi;

                let modalContent = '';

                if (belumTerisi > 0) {
                    modalContent = `
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Submit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda sudah mengisi ${terisi} dari ${totalSoal} pertanyaan.</p>
                        <p>Masih ada ${belumTerisi} pertanyaan yang belum diisi. Lanjutkan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="konfirmasiSubmit">Lanjutkan</button>
                    </div>
                `;
                } else {
                    modalContent = `
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Submit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Semua pertanyaan sudah terisi.</p>
                        <p>Anda sudah mengisi semua ${totalSoal} pertanyaan.</p>
                        <p>Lanjutkan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="konfirmasiSubmit">Lanjutkan</button>
                    </div>
                `;
                }


                // Menampilkan modal
                $('#konfirmasiModal .modal-content').html(modalContent);
                $('#konfirmasiModal').modal('show');

                // Event handler untuk tombol submit pada modal
                $('#konfirmasiSubmit').on('click', function() {
                    $('#form-penilaian').unbind('submit').submit();
                });
            });

            const pertanyaanTerakhir = $('.btn-soal').last().data('pertanyaan');

            btnSoal.on('click', function(e) {
                e.preventDefault();
                const pertanyaanID = $(this).data('pertanyaan');
                const pertanyaan = $('.pertanyaan[data-pertanyaan="' + pertanyaanID + '"]');

                // Tampilkan pertanyaan yang sesuai
                $('.pertanyaan').hide();
                pertanyaan.show();

                // Cek apakah pertanyaan terakhir yang diklik
                if (pertanyaanID == pertanyaanTerakhir) {
                    $('#btn-selesai').prop('disabled', false); // Enable tombol
                }
            });
        });
    </script>
@endsection
