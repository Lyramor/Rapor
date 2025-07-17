{{-- resources/views/whistleblower/Admin/navbar.blade.php --}}
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
                                    <a class="nav-link {{ request()->routeIs('admin.whistleblower.dashboard') ? 'active' : '' }}" 
                                       href="{{ route('admin.whistleblower.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                
                                <!-- Manajemen Pengaduan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.whistleblower.*') ? 'active' : '' }}" 
                                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Manajemen Pengaduan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('admin.whistleblower.index') ? 'active' : '' }}" 
                                               href="{{ route('admin.whistleblower.index') }}">
                                                Semua Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('admin.whistleblower.index', ['status' => 'pending']) }}">
                                                Menunggu Review
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('admin.whistleblower.index', ['status' => 'proses']) }}">
                                                Dalam Proses
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('admin.whistleblower.index', ['status' => 'selesai']) }}">
                                                Selesai
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Laporan & Analisis -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Laporan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.whistleblower.export') }}">
                                                Export Data
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Statistik Kategori
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Laporan Bulanan
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                @if(session('selected_role') == 'Admin PPKPT Fakultas')
                                <!-- Khusus untuk Admin Fakultas -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Fakultas
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Tim PPKPT Fakultas
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Pengaduan Per Prodi
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                
                                @if(session('selected_role') == 'Admin PPKPT Prodi')
                                <!-- Khusus untuk Admin Prodi -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Program Studi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Pengaduan Mahasiswa
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                Pengaduan Dosen
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif

                                <!-- Pengaturan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pengaturan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.whistleblower.kategori') }}">
                                                Kategori Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.whistleblower.settings') }}">
                                                Pengaturan Sistem
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('whistleblower.index') }}">
                                                Lihat sebagai User
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                            <!-- User Info di kanan -->
                            <ul class="navbar-nav ms-auto">
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
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>