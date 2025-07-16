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
                                        href="{{ route('master') }}">Dashboard</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Sinkronasi
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('master.sinkronasi') }}">Data</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('master.sinkronasi.remedial') }}">Remedial</a></li>
                                        {{-- <li><a class="dropdown-item" href="{{ route('master.user') }}">Vakasi</a></li> --}}
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Master
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('master.modul') }}">Modul</a></li>
                                        <li><a class="dropdown-item" href="{{ route('master.role') }}">Role</a></li>
                                        <li><a class="dropdown-item" href="{{ route('master.user') }}">User</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page"
                                        href="{{ route('master.pegawai') }}">Pegawai</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Referensi
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('master.unit-kerja') }}">Unit
                                                Kerja</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Laporan
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('master.laporan') }}">Laporan</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
