<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Atur lebar sidebar */
        .sidebar-konten {
            border-right: 1px solid #dee2e6;
        }

        /* Atur warna aktif untuk link sidebar */
        .sidebar-konten .nav-link.active {
            font-weight: bold;
            color: #007bff;
        }

        /* Atur gaya untuk setiap item link */
        .sidebar-konten .nav-item {
            margin-bottom: 5px;
        }

        /* Atur warna latar belakang dan border untuk setiap item link */
        .sidebar-konten .nav-item a {
            display: block;
            padding: 10px;
            background-color: #fff;
            /* Warna latar belakang item */
            border-left: 4px solid transparent;
            /* Garis kiri item */
            transition: background-color 0.3s, border-left-color 0.3s;
            /* Transisi efek hover */
            color: #007bff;
            /* Warna teks biru */
        }

        /* Efek hover pada item link */
        .sidebar-konten .nav-item a:hover {
            background-color: #f8f9fa;
            border-left-color: #6a9dd3;
            /* Warna latar belakang item saat dihover */
        }

        /* Atur warna latar belakang dan border untuk item yang aktif */
        .sidebar-konten .nav-item a.active {
            background-color: #f8f9fa;
            /* Warna latar belakang item aktif */
            color: #007bff;
            /* Warna teks putih untuk item aktif */
            border-left-color: #007bff;
            /* Warna border kiri item aktif */
        }
    </style>
</head>

<body>
    <div class="sidebar-konten">
        <ul class="nav flex-column">
            <li class="nav-item">
                @if (Request::is('*/jadwal/create*'))
                @else
                    <a class="nav-link {{ Request::is('*/jadwal/edit*') ? 'active' : '' }}"
                        href="{{ route('btq.jadwal.edit', $jadwal->id) }}">
                        Jadwal BTQ
                    </a>
                    <a class="nav-link {{ Request::is('*/jadwal/peserta*') ? 'active' : '' }}"
                        href="{{ route('btq.jadwal.daftar-peserta', $jadwal->id) }}">
                        Peserta
                    </a>
                @endif
                {{-- <a class="nav-link {{ Request::is('*/pelaksanaan/daftar-mk/kelas*') ? 'active' : '' }}"
                    href="{{ route('remedial.pelaksanaan.daftar-mk.kelas', [
                        'kode_periode' => $matakuliah->kode_periode,
                        'idmk' => $matakuliah->idmk,
                        'remedial_periode_id' => $matakuliah->remedialajuan->remedial_periode_id,
                    ]) }}">
                    Kelas Remedial
                </a> --}}

            </li>
        </ul>
    </div>
</body>

</html>
