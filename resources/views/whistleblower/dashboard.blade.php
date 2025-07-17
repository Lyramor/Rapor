{{-- resources/views/whistleblower/dashboard.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Dashboard Whistleblower</h2>
                    <p class="text-muted">Sistem Pencegahan dan Penanganan Kekerasan Seksual</p>
                </div>
                <div>
                    <a href="{{ route('whistleblower.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus"></i> Buat Pengaduan Baru
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                            <h5>Buat Pengaduan</h5>
                            <p class="text-muted">Laporkan insiden yang terjadi</p>
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">Mulai</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-3x text-info mb-3"></i>
                            <h5>Riwayat</h5>
                            <p class="text-muted">Lihat pengaduan yang pernah dibuat</p>
                            <a href="{{ route('whistleblower.index') }}" class="btn btn-info">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-search fa-3x text-warning mb-3"></i>
                            <h5>Cek Status</h5>
                            <p class="text-muted">Lacak status pengaduan anonim</p>
                            <a href="{{ route('whistleblower.status-page') }}" class="btn btn-warning">Cek</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x text-success mb-3"></i>
                            <h5>Kontak Darurat</h5>
                            <p class="text-muted">Hubungi tim PPKPT</p>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKontak">Kontak</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['total_pengaduan'] }}</h3>
                            <p class="mb-0">Total Pengaduan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p class="mb-0">Menunggu Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['proses'] }}</h3>
                            <p class="mb-0">Dalam Proses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['selesai'] }}</h3>
                            <p class="mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Riwayat Pengaduan Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @if($riwayat_pengaduan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($riwayat_pengaduan as $pengaduan)
                                            <tr>
                                                <td>
                                                    <strong>{{ $pengaduan->kode_pengaduan }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $pengaduan->kategori->nama ?? 'Lainnya' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($pengaduan->status_pengaduan == 'pending')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif($pengaduan->status_pengaduan == 'proses')
                                                        <span class="badge bg-info">Proses</span>
                                                    @else
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('whistleblower.show', $pengaduan->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('whistleblower.index') }}" class="btn btn-outline-primary">
                                        Lihat Semua Pengaduan <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum Ada Pengaduan</h5>
                                    <p class="text-muted">Anda belum pernah membuat pengaduan.</p>
                                    <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Buat Pengaduan Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Informasi Penting -->
                    <div class="card mb-3">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-exclamation-triangle"></i> Informasi Penting
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-2">
                                <small>
                                    <strong>Kerahasiaan Terjamin:</strong> Identitas pelapor akan dijaga kerahasiaannya sesuai dengan peraturan yang berlaku.
                                </small>
                            </div>
                            <div class="alert alert-info mb-2">
                                <small>
                                    <strong>Respon Cepat:</strong> Tim PPKPT akan merespons pengaduan dalam maksimal 3x24 jam.
                                </small>
                            </div>
                            <div class="alert alert-success mb-0">
                                <small>
                                    <strong>Perlindungan Pelapor:</strong> Tidak ada tindakan balasan untuk pelapor yang beritikad baik.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-phone"></i> Kontak Darurat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Hotline PPKPT:</strong><br>
                                <i class="fas fa-phone text-success"></i> 0274-123456<br>
                                <i class="fab fa-whatsapp text-success"></i> 08123456789
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong><br>
                                <i class="fas fa-envelope text-primary"></i> ppkpt@university.ac.id
                            </div>
                            <div class="mb-0">
                                <strong>Layanan 24/7:</strong><br>
                                <span class="badge bg-success">Online</span> Chat Support
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kontak Darurat -->
<div class="modal fade" id="modalKontak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-phone"></i> Kontak Darurat PPKPT
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Hotline Telepon</h6>
                        <p>
                            <i class="fas fa-phone text-success"></i> 0274-123456<br>
                            <small class="text-muted">24 jam setiap hari</small>
                        </p>
                        
                        <h6>WhatsApp</h6>
                        <p>
                            <i class="fab fa-whatsapp text-success"></i> 08123456789<br>
                            <small class="text-muted">Chat & Voice Call</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Email</h6>
                        <p>
                            <i class="fas fa-envelope text-primary"></i> ppkpt@university.ac.id<br>
                            <small class="text-muted">Respon dalam 6 jam</small>
                        </p>
                        
                        <h6>Live Chat</h6>
                        <p>
                            <span class="badge bg-success">Online</span><br>
                            <small class="text-muted">Tersedia di website</small>
                        </p>
                    </div>
                </div>
                
                <div class="alert alert-danger mt-3">
                    <h6><i class="fas fa-exclamation-triangle"></i> Kondisi Darurat</h6>
                    <p class="mb-0">Jika dalam kondisi darurat yang mengancam keselamatan, segera hubungi:</p>
                    <ul class="mb-0 mt-2">
                        <li>Polisi: <strong>110</strong></li>
                        <li>Ambulans: <strong>118</strong></li>
                        <li>Pemadam Kebakaran: <strong>113</strong></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="tel:0274123456" class="btn btn-success">
                    <i class="fas fa-phone"></i> Hubungi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection