@extends('layouts.main')

@section('css-tambahan')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="judul-modul">
                    <h3>Indikator Kinerja</h3>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-6">
                    <form action="#" method="POST" target="_blank">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="periode_rapor" class="text-right mb-0 pr-2 col-md-3">Periode</label>
                                            <select id="periode-dropdown" class="form-select"
                                                aria-label="Default select example" name="periode_rapor" required>
                                                <option value="">Pilih Periode...</option>
                                                @foreach ($daftar_periode as $periode)
                                                    <option value="{{ $periode->kode_periode }}">
                                                        {{ $periode->nama_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="program-studi" class="text-right mb-0 pr-2 col-md-3">Program
                                                Studi</label>
                                            <select id="program-studi" class="form-select" name="programstudi" required>
                                                <option value="">Pilih Program Studi...</option>
                                                @foreach ($daftar_programstudi as $programstudi)
                                                    <option value="{{ $programstudi->nama }}">{{ $programstudi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="search-nama-nip" class="text-right mb-0 pr-2 col-md-3">Nama
                                                Dosen</label>
                                            <input type="text" class="form-control typeahead" id="nama-dosen"
                                                name="nama-dosen" placeholder="Masukkan NIP atau Nama Dosen">
                                            <input type="hidden" id="dosen_nip" name="dosen_nip">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="background-color: white">
                                <button type="submit" class="btn btn-primary float-end">Tampilkan</button>
                                <button type="reset" class="btn btn-secondary float-end me-2">Reset</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="isi-konten">

    </div>
    </div>
@endsection

@section('js-tambahan')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            // Inisialisasi Typeahead
            $('#search-nama-nip').typeahead({
                source: function(query, process) {
                    return $.ajax({
                        url: "/dosen/get-nama-dosen/",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            return process(data);
                        }
                    });
                },
                autoSelect: true
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi Typeahead
            $('#nama-dosen').typeahead({
                source: function(query, process) {
                    return $.ajax({
                        url: "/dosen/get-nama-dosen/",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Format data untuk menampilkan NIP - Nama Dosen
                            var formattedData = [];

                            $.each(data, function(index, item) {
                                var displayText = item.nip + ' - ' + item.nama;
                                formattedData.push(displayText);
                            });

                            return process(formattedData);
                        }
                    });
                },
                autoSelect: true,
                updater: function(item) {
                    var parts = item.split(' - ');
                    $('#nama-dosen').val(parts[1]); // Set nilai input nama-dosen
                    $('#dosen_nip').val(parts[0]); // Set nilai input hidden nip-dosen
                    return parts[1]; // Tampilkan nama dosen di input
                }
            });

            // Validasi form saat change dari input nama - dosen
            // $('#nama-dosen').change(function() {
            //     var value = $(this).val();
            //     var data = $('#nama-dosen').data('typeahead').source;
            //     if ($.inArray(value, data) === -1) {
            //         $(this).val(''); // Kosongkan nilai input jika tidak ada di autocomplete
            //         $('#dosen_nip').val(''); // Kosongkan nilai hidden nip-dosen
            //         // alert('Silakan pilih nama dosen dari autocomplete!');
            //     }
            // });

            // Fungsi untuk reset formulir
            $('#form-filter').on('reset', function() {
                $('#nama-dosen').val(''); // Kosongkan nilai input nama-dosen
                $('#dosen_nip').val(''); // Kosongkan nilai input hidden nip-dosen
            });
        });
    </script>
@endsection
