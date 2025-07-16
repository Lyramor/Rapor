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
                                        href="{{ route('kuesioner') }}">Dashboard</a>
                                </li>

                                {{-- jika memiliki session selected role sebagai admin --}}
                                @if (session('selected_role') == 'Admin')
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Kuesioner
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="{{ route('kuesioner.banksoal') }}">Bank
                                                    Soal</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('kuesioner.kuesioner-sdm') }}">Kuesioner SDM</a>
                                            </li>
                                            {{-- <li><a class="dropdown-item" href="{{ route('master.user') }}">Kuesioner Unit
                                                Kerja</a></li> --}}

                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
