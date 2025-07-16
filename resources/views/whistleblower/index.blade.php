@extends('layouts.main')

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Whistleblower - Laporan Saya</h2>
                    <p class="text-muted">Sistem Pencegahan dan Penanganan Kekerasan Seksual</p>
                </div>
                <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Laporan Baru
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    @if(session('kode_pengaduan'))
                        <br><strong>Kode Pengaduan: {{ session('kode_pengaduan') }}</strong>
                        <br><small>Simpan kode ini untuk melacak status pengaduan Anda.</small>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total'] }}</h4>
                                    <p class="mb-0">Total Laporan</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['pending'] }}</h4>
                                    <p class="mb-0">Menunggu</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['proses'] }}</h4>
                                    <p class="mb-0">Dalam Proses</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-spinner fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['selesai'] }}</h4>
                                    <p class="mb-0">Selesai</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Laporan Saya</h5>
                </div>
                <div class="card-body">
                    @if($pengaduan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan as $item)
                                        <tr>
                                            <td>
                                                <code>{{ $item->kode_pengaduan }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ Str::limit($item->judul_pengaduan, 40) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $item->kategori->nama_kategori }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->status_badge }}">
                                                    {{ $item->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $item->tanggal_pengaduan->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if($item->lampiran->count() > 0)
                                                    <span class="badge bg-info">
                                                        {{ $item->lampiran->count() }} file
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('whistleblower.show', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pengaduan->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Laporan</h5>
                            <p class="text-muted">Anda belum membuat laporan apapun.</p>
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Laporan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Penting</h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Semua laporan akan ditangani dengan kerahasiaan tinggi</li>
                                <li>Anda dapat membuat laporan secara anonim</li>
                                <li>Status laporan dapat dipantau menggunakan kode pengaduan</li>
                                <li>Tim PPKPT akan menindaklanjuti setiap laporan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-shield-alt"></i> Kerahasiaan Terjamin</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Sistem ini menjamin:</p>
                            <ul class="mb-0">
                                <li>Identitas pelapor dilindungi</li>
                                <li>Data terenkripsi dan aman</li>
                                <li>Akses terbatas hanya untuk tim PPKPT</li>
                                <li>Proses penanganan profesional</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css-tambahan')
<style>
.badge-warning {
    background-color: #ffc107 !important;
}
.badge-info {
    background-color: #17a2b8 !important;
}
.badge-success {
    background-color: #28a745 !important;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.table th {
    background-color: #f8f9fa;
    border-top: none;
}
</style>
@endsection@extends('layouts.main')

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Whistleblower - Laporan Saya</h2>
                    <p class="text-muted">Sistem Pencegahan dan Penanganan Kekerasan Seksual</p>
                </div>
                <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Laporan Baru
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    @if(session('kode_pengaduan'))
                        <br><strong>Kode Pengaduan: {{ session('kode_pengaduan') }}</strong>
                        <br><small>Simpan kode ini untuk melacak status pengaduan Anda.</small>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total'] }}</h4>
                                    <p class="mb-0">Total Laporan</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['pending'] }}</h4>
                                    <p class="mb-0">Menunggu</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['proses'] }}</h4>
                                    <p class="mb-0">Dalam Proses</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-spinner fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['selesai'] }}</h4>
                                    <p class="mb-0">Selesai</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Laporan Saya</h5>
                </div>
                <div class="card-body">
                    @if($pengaduan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan as $item)
                                        <tr>
                                            <td>
                                                <code>{{ $item->kode_pengaduan }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ Str::limit($item->judul_pengaduan, 40) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $item->kategori->nama_kategori }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->status_badge }}">
                                                    {{ $item->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $item->tanggal_pengaduan->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if($item->lampiran->count() > 0)
                                                    <span class="badge bg-info">
                                                        {{ $item->lampiran->count() }} file
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('whistleblower.show', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pengaduan->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Laporan</h5>
                            <p class="text-muted">Anda belum membuat laporan apapun.</p>
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Laporan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Penting</h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Semua laporan akan ditangani dengan kerahasiaan tinggi</li>
                                <li>Anda dapat membuat laporan secara anonim</li>
                                <li>Status laporan dapat dipantau menggunakan kode pengaduan</li>
                                <li>Tim PPKPT akan menindaklanjuti setiap laporan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-shield-alt"></i> Kerahasiaan Terjamin</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Sistem ini menjamin:</p>
                            <ul class="mb-0">
                                <li>Identitas pelapor dilindungi</li>
                                <li>Data terenkripsi dan aman</li>
                                <li>Akses terbatas hanya untuk tim PPKPT</li>
                                <li>Proses penanganan profesional</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css-tambahan')
<style>
.badge-warning {
    background-color: #ffc107 !important;
}
.badge-info {
    background-color: #17a2b8 !important;
}
.badge-success {
    background-color: #28a745 !important;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.table th {
    background-color: #f8f9fa;
    border-top: none;
}
</style>
@endsection