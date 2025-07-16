<div class="menu-navbar">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light bg-light">
                    <div class="">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ route('remedial') }}">Dashboard</a>
                                </li>

                                @if (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas')
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Pengaturan
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('remedial.periode') }}">Periode</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                @if (session('selected_role') == 'Admin' ||
                                        session('selected_role') == 'Admin Fakultas' ||
                                        session('selected_role') == 'Admin Prodi')
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Ajuan
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            @if (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas')
                                                <li><a class="dropdown-item"
                                                        href="{{ route('remedial.ajuan') }}">Verifikasi</a>
                                                </li>
                                            @endif
                                            <li><a class="dropdown-item"
                                                    href="{{ route('remedial.ajuan.daftarAjuan') }}">Daftar
                                                    Ajuan</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('remedial.ajuan.daftarAjuan') }}">Kelayakan</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Pelaksanaan
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @if (session('selected_role') == 'Admin' ||
                                                session('selected_role') == 'Admin Fakultas' ||
                                                session('selected_role') == 'Admin Prodi')
                                            <li><a class="dropdown-item"
                                                    href="{{ route('remedial.pelaksanaan.daftar-mk') }}">Daftar
                                                    Matakuliah</a>
                                            </li>
                                        @endif
                                        <li><a class="dropdown-item"
                                                href="{{ route('remedial.pelaksanaan.daftar-kelas') }}">Daftar
                                                Kelas</a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page"
                                        href="{{ route('remedial.laporan') }}">Laporan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
