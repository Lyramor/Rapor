{{-- resources/views/whistleblower/Admin/dashboard.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.Admin.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Dashboard Admin PPKPT</h2>
                    <p class="text-muted">Sistem Pencegahan dan Penanganan Kekerasan Seksual</p>
                    <span class="badge bg-danger fs-6">{{ session('selected_role') }}</span>
                </div>
                <div>
                    <a href="{{ route('admin.whistleblower.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export Data
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['total'] }}</h4>
                            <small>Total Pengaduan</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['pending'] }}</h4>
                            <small>Menunggu Review</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['proses'] }}</h4>
                            <small>Dalam Proses</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['selesai'] }}</h4>
                            <small>Selesai</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['anonim'] }}</h4>
                            <small>Anonim</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['bulan_ini'] }}</h4>
                            <small>Bulan Ini</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Row -->
            <div class="row">
                <!-- Pengaduan yang Perlu Ditangani -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pengaduan yang Perlu Ditangani</h5>
                            <a href="{{ route('admin.whistleblower.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            @if($pengaduan_terbaru->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Pelapor</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pengaduan_terbaru as $pengaduan)
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
                                                    @else
                                                        <span class="badge bg-info">Proses</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pengaduan->anonymous)
                                                        <em class="text-muted">Anonim</em>
                                                    @else
                                                        {{ $pengaduan->pelapor->name ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.whistleblower.show', $pengaduan->id) }}" 
                                                           class="btn btn-outline-primary" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-outline-success" 
                                                                onclick="updateStatus({{ $pengaduan->id }}, 'proses')"
                                                                title="Proses">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-muted">Semua Pengaduan Telah Ditangani</h5>
                                    <p class="text-muted">Tidak ada pengaduan yang memerlukan tindakan segera.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="col-md-4">
                    <!-- Statistik Kategori -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Statistik per Kategori</h6>
                        </div>
                        <div class="card-body">
                            @foreach($stats_kategori as $kategori)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small">{{ $kategori->nama }}</span>
                                    <span class="badge bg-primary">{{ $kategori->pengaduan_count }}</span>
                                </div>
                                <div class="progress mb-3" style="height: 5px;">
                                    <div class="progress-bar" 
                                         style="width: {{ $stats['total'] > 0 ? ($kategori->pengaduan_count / $stats['total']) * 100 : 0 }}%">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Grafik Tren Bulanan -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Tren 6 Bulan Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartBulanan" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Aksi Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('admin.whistleblower.index', ['status' => 'pending']) }}" 
                                       class="btn btn-outline-warning w-100">
                                        <i class="fas fa-clock"></i><br>
                                        Pengaduan Pending
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.whistleblower.index', ['status' => 'proses']) }}" 
                                       class="btn btn-outline-info w-100">
                                        <i class="fas fa-cog"></i><br>
                                        Dalam Proses
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.whistleblower.export') }}" 
                                       class="btn btn-outline-success w-100">
                                        <i class="fas fa-download"></i><br>
                                        Export Laporan
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalStatistik">
                                        <i class="fas fa-chart-bar"></i><br>
                                        Statistik Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUpdateStatus">
                <div class="modal-body">
                    <input type="hidden" id="pengaduanId">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="statusPengaduan" required>
                            <option value="pending">Pending</option>
                            <option value="proses">Dalam Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatanStatus" rows="3" 
                                  placeholder="Catatan untuk perubahan status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js untuk grafik bulanan
const ctx = document.getElementById('chartBulanan').getContext('2d');
const chartBulanan = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($stats_bulanan, 'bulan')) !!},
        datasets: [{
            label: 'Pengaduan',
            data: {!! json_encode(array_column($stats_bulanan, 'total')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Function untuk update status
function updateStatus(id, status) {
    document.getElementById('pengaduanId').value = id;
    document.getElementById('statusPengaduan').value = status;
    
    const modal = new bootstrap.Modal(document.getElementById('modalUpdateStatus'));
    modal.show();
}

// Submit form update status
document.getElementById('formUpdateStatus').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('pengaduanId').value;
    const status = document.getElementById('statusPengaduan').value;
    const catatan = document.getElementById('catatanStatus').value;
    
    // AJAX request untuk update status
    fetch(`/admin/whistleblower/${id}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: status,
            catatan: catatan
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengupdate status');
        }
    });
});
</script>
@endsection