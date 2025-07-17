{{-- resources/views/whistleblower/navbar.blade.php --}}
<div class="menu-navbar">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light bg-light">
                    <div class="">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <!-- Dashboard -->
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('whistleblower.user.dashboard') ? 'active' : '' }}" 
                                       href="{{ route('whistleblower.user.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                
                                <!-- Pengaduan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('whistleblower.*') ? 'active' : '' }}" 
                                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pengaduan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('whistleblower.create') ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.create') }}">
                                                Buat Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('whistleblower.index') ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.index') }}">
                                                Riwayat Pengaduan
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('whistleblower.status-page') }}">
                                                Cek Status (Anonim)
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Informasi -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Informasi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPanduan">
                                                Panduan Pelaporan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalKategori">
                                                Kategori Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPrivasi">
                                                Kebijakan Privasi
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalKontak">
                                                Kontak Darurat
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Bantuan -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalBantuan">
                                        Bantuan
                                    </a>
                                </li>
                            </ul>
                            
                            {{-- <!-- User Info di kanan -->
                            <ul class="navbar-nav ms-auto">
                                @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ auth()->user()->name }}
                                        <small class="d-block text-muted">{{ session('selected_role') }}</small>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        Login
                                    </a>
                                </li>
                                @endauth
                            </ul> --}}
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Modal Panduan --}}
<div class="modal fade" id="modalPanduan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Panduan Pelaporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Langkah-langkah Pelaporan:</h6>
                <ol>
                    <li>Klik menu "Buat Pengaduan"</li>
                    <li>Pilih kategori pengaduan yang sesuai</li>
                    <li>Isi detail pengaduan dengan jelas dan lengkap</li>
                    <li>Lampirkan bukti jika ada</li>
                    <li>Pilih apakah ingin melaporkan secara anonim atau tidak</li>
                    <li>Submit pengaduan</li>
                    <li>Catat kode pengaduan untuk tracking</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Modal Kategori --}}
<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kategori Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Kekerasan Seksual</li>
                    <li>Pelecehan Seksual</li>
                    <li>Diskriminasi</li>
                    <li>Bullying/Perundungan</li>
                    <li>Penyalahgunaan Wewenang</li>
                    <li>Lainnya</li>
                </ul>
            </div>
        </div>
    </div>
</div>