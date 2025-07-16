<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Gate Menu</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Mengatur font-family menjadi Poppins */
            background-image: url('{{ asset('storage/images/login-side-left.jpg') }}');
            background-size: cover;
        }

        .box {
            /* margin-top: 10px; */
            margin: 20px auto;
            width: 980px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            /* border radius untuk membuat sudut melengkung */
            padding: 10px;
            /* menambahkan padding agar card tidak terlalu dekat dengan border */
        }

        .card {
            width: 940px;
            min-height: 500px;
            background-color: #eee;
            margin: 10px auto;
            /* untuk membuat card berada di tengah halaman */
            border: 0px solid rgba(0, 0, 0, 0.2);
            /* border dengan warna transparan */
            border-radius: 10px;
            /* border radius untuk membuat sudut melengkung */
        }

        .card-header {
            padding: 20px 20px 10px 20px;
            color: white;
            background-color: rgba(0, 0, 139, 0.55);
            /* background dengan transparansi */
            background-image: url('{{ asset('storage/images/bg-pattern.png') }}');
            /* URL gambar latar belakang */
            background-repeat: repeat;
            /* Gambar latar belakang diulang */
            line-height: 0.5;
        }

        .logo {
            width: 100px;
            /* Memastikan lebar logo maksimal */
            height: auto;
            /* Menyesuaikan tinggi logo secara otomatis */
            margin: 10px auto;
            /* Memberikan jarak kanan antara logo dan teks */
        }

        .judul-app {
            margin-top: 10px;
        }

        .exit-button {
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna latar belakang merah dengan opasitas 50% */
            color: #fff;
            /* Warna teks putih */
            border: none;
            /* Menghapus border */
            padding: 10px 20px;
            /* Padding untuk memberikan ruang di dalam tombol */
            border-radius: 5px;
            /* Border radius untuk sudut melengkung */
            cursor: pointer;
            /* Mengubah kursor menjadi tangan saat dihover */
            transition: background-color 0.3s ease;
            /* Efek transisi pada perubahan warna latar belakang */
            margin: 5px;
        }

        .exit-button:hover {
            background-color: rgba(0, 0, 0, 0.8);
            /* Warna latar belakang merah yang sedikit lebih gelap saat dihover */
        }

        .button-app {
            display: flex;
            /* Menggunakan flexbox */
            align-items: center;
            /* Mengatur seluruh elemen agar berada pada sumbu vertikal yang sama */
        }

        .card-body {
            padding: 0px;
        }

        .daftar-modul {
            margin-top: 20px;
        }

        .daftar-role {
            margin-top: 20px;
            /* background-color: #eae0e0; */
        }

        .kotak-modul {
            display: flex;
            flex-wrap: wrap;
        }

        .modul {
            display: flex;
            text-decoration: none;
            color: black;
            font-size: 14px;
            flex-direction: column;
            /* Menetapkan tata letak kolom untuk isi modul */
            justify-content: center;
            /* Menyusun isi secara vertikal di tengah */
            align-items: center;
            /* Menyusun isi secara horizontal di tengah */
            width: calc(30% - 10px);
            /* 33.33% untuk tiga kotak per baris, -10px untuk margin antar kotak */
            margin: 10px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            /* Efek transisi pada perubahan warna latar belakang dan skala */
        }

        .modul:hover {
            transform: scale(1.05);
            /* Memperbesar modul saat menghover */
        }

        .modul img {
            max-width: 100%;
            /* Membuat gambar agar tidak melebihi lebar modul */
        }

        .modul:hover {
            background-color: #e0e0e0;
            /* Warna latar belakang yang berbeda saat mouse dihover */
        }

        .kotak-role {
            display: flex;
            flex-direction: column;
        }

        .role {
            line-height: 0.5;
            min-height: 70px;
            width: 100%;
            padding: 20px;
            margin-bottom: 10px;
            background-color: white;
            border-radius: 5px;
            transition: background-color 0.1s ease, color 0.1s ease;
            /* Efek transisi pada perubahan warna latar belakang dan warna teks */
        }

        .role:hover {
            background-color: rgba(0, 0, 139, 0.55);
            /* Warna latar belakang biru saat mouse dihover */
            color: #ffffff;
            /* Warna teks putih saat mouse dihover */
        }

        .role p {
            color: rgba(0, 0, 139, 0.55);
            ;
            /* Warna biru untuk teks paragraf */
        }

        .role span {
            color: rgba(101, 101, 101, 0.55);
            ;
            /* Warna biru untuk teks paragraf */
        }

        .role:hover p {
            color: #ffffff;
            /* Warna putih untuk teks paragraf saat dihover */
        }

        .role:hover span {
            color: #ffffff;
            /* Warna putih untuk teks paragraf saat dihover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="card">
                    <div class="card-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-10">
                                    <div class="judul-app">
                                        <h4 class="card-title">LINK APP</h4>
                                        <p><strong>UNIVERSITAS PASUNDAN</strong></p>
                                    </div>
                                    <div class="button-app">
                                        {{-- button redirect to gate() --}}
                                        <a href="{{ route('changePasswordSecond') }}" style="text-decoration: none"
                                            class="exit-button">Ganti Password</a>
                                        {{-- to logout --}}


                                        <form action="{{ url('/login/exit') }}" method="post">
                                            @csrf
                                            <button type="submit" class="exit-button">Keluar</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <img src="{{ asset('storage/images/unpas-logo.png') }}" alt="Logo UNPAS"
                                        class="logo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-7 daftar-modul">
                                    @if (session('message'))
                                        <div class="isi-konten">
                                            <div class="row justify-content-md-center">
                                                <div class="col-12">
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('message') }}

                                                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, assumenda. --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <h4 class="card-title">Daftar Modul</h4>
                                    <p style="margin-bottom:20px">Selamat datang, {{ auth()->user()->name }}</p>
                                    <div class="kotak-modul">
                                        @foreach ($moduls as $modul)
                                            <a href="#" class="modul"
                                                onclick="showRoles('{{ $modul['id'] }}','{{ $modul['tautan'] }}')">
                                                <img src="{{ asset('path/to/icon/' . $modul->icon) }}"
                                                    alt="Logo {{ $modul['nama_modul'] }}"
                                                    style="width: 80px;height: 80px">
                                                <p>{{ $modul['nama_modul'] }}</p>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-5 daftar-role">
                                    <h4 class="card-title">Daftar Role</h4>
                                    <p style="margin-bottom:20px" id="judul-role"></p>
                                    <div class="kotak-role" id="daftar-role" style="display: none;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function showRoles(modul_id, route) {
            $.ajax({
                url: `/data/get-roles/${modul_id}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    const roleContainer = $('#daftar-role');
                    roleContainer.empty(); // Mengosongkan kontainer sebelum memasukkan data baru
                    const judulRole = $('#judul-role');
                    judulRole.text(route);

                    data.forEach(function(item) {
                        const role = item.role; // Akses objek role dari setiap item
                        const unitkerja = item.unitkerja; // Akses objek unirkerja dari setiap item

                        const roleDiv = $('<div>').addClass('role');

                        const roleLink = $('<span>').addClass('role-link')
                            .css('text-decoration', 'none')
                            .css('cursor', 'pointer')
                            .click(function() {
                                setRole(role.id, unitkerja.id, route);
                            });

                        const roleJudul = $('<p>').addClass('role-judul')
                            .html(`<strong>${role.name}</strong>`);

                        const roleBidang = $('<span>').addClass('role-bidang')
                            .text(unitkerja.nama_unit);

                        roleLink.append(roleJudul);
                        roleLink.append(roleBidang);
                        roleDiv.append(roleLink);
                        roleContainer.append(roleDiv);
                    });


                    roleContainer.css('display', 'block'); // Menampilkan kotak role setelah data dimasukkan
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', error);
                }
            });
        }

        function setRole(role, unitkerja, route) {
            // Mengatur session role dengan nilai role yang dipilih
            fetch('{{ route('gate.setRole') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        role: role,
                        unitkerja: unitkerja
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Jika session role diatur dengan sukses, redirect ke route yang ditentukan
                        window.location.href = route;
                    } else {
                        console.error('Gagal mengatur session role');
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }
    </script>
</body>

</html>
