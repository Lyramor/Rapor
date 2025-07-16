@extends('layouts.main')

@section('konten')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Admin PPKPT - Manajemen Pengaduan</h2>
                        <p class="text-muted">Sistem Pencegahan dan Penanganan Kekerasan Seksual</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.whistleblower.dashboard') }}" class="btn btn-info me-2">
                            <i class="fas fa-chart-bar"></i> Dashboard
                        </a>
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
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4>{{ $stats['pending'] }}</h4>
                                <small>Menunggu</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h4>{{ $stats['proses'] }}</h4>
                                <small>Proses</small>
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

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Filter Pencarian</h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.whistleblower.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Menunggu</option>
                                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Dalam
                                            Proses</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ request('tanggal_mulai') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ request('tanggal_selesai') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" placeholder="Kode/Judul..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.whistleblower.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reports Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Pengaduan ({{ $pengaduan->total() }} total)</h5>
                    </div>
                    <div class="card-body">
                        @if ($pengaduan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Judul</th>
                                            <th>Pelapor</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengaduan as $item)
                                            <tr>
                                                <td>
                                                    <code>{{ $item->kode_pengaduan }}</code>
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($item->judul_pengaduan, 40) }}</strong>
                                                    @if ($item->anonymous)
                                                        <br><small class="text-muted"><i class="fas fa-user-secret"></i>
                                                            Anonim</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->anonymous)
                                                        <span class="text-muted">Anonim</span>
                                                    @else
                                                        {{ $item->pelapor->name ?? 'N/A' }}
                                                        <br><small
                                                            class="text-muted">{{ $item->pelapor->email ?? '' }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $item->kategori->nama_kategori }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm status-update"
                                                        data-id="{{ $item->id }}"
                                                        data-current="{{ $item->status_pengaduan }}">
                                                        <option value="pending"
                                                            {{ $item->status_pengaduan == 'pending' ? 'selected' : '' }}>
                                                            Menunggu</option>
                                                        <option value="proses"
                                                            {{ $item->status_pengaduan == 'proses' ? 'selected' : '' }}>
                                                            Dalam Proses</option>
                                                        <option value="selesai"
                                                            {{ $item->status_pengaduan == 'selesai' ? 'selected' : '' }}>
                                                            Selesai</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    {{ $item->tanggal_pengaduan->format('d/m/Y H:i') }}
                                                    <br><small
                                                        class="text-muted">{{ $item->tanggal_pengaduan->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.whistleblower.show', $item->id) }}"
                                                            class="btn btn-outline-primary" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($item->lampiran->count() > 0)
                                                            <button class="btn btn-outline-info"
                                                                title="{{ $item->lampiran->count() }} Lampiran">
                                                                <i class="fas fa-paperclip"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pengaduan->withQueryString()->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak Ada Data</h5>
                                <p class="text-muted">Tidak ada pengaduan yang sesuai dengan filter yang dipilih.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Update Status -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        <input type="hidden" id="pengaduanId">
                        <div class="mb-3">
                            <label class="form-label">Status Baru</label>
                            <select id="newStatus" class="form-select">
                                <option value="pending">Menunggu</option>
                                <option value="proses">Dalam Proses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea id="catatan" class="form-control" rows="3"
                                placeholder="Tambahkan catatan untuk perubahan status..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmUpdate">Update Status</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Handle status update
            $('.status-update').change(function() {
                const pengaduanId = $(this).data('id');
                const currentStatus = $(this).data('current');
                const newStatus = $(this).val();

                if (newStatus !== currentStatus) {
                    $('#pengaduanId').val(pengaduanId);
                    $('#newStatus').val(newStatus);
                    $('#catatan').val('');
                    $('#statusModal').modal('show');
                }
            });

            // Confirm status update
            $('#confirmUpdate').click(function() {
                const pengaduanId = $('#pengaduanId').val();
                const newStatus = $('#newStatus').val();
                const catatan = $('#catatan').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `/admin/whistleblower/${pengaduanId}/status`,
                    method: 'PUT',
                    data: {
                        status: newStatus,
                        catatan: catatan
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#statusModal').modal('hide');

                            // Update the select element
                            $(`.status-update[data-id="${pengaduanId}"]`).data('current',
                                newStatus);

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message ||
                                'Terjadi kesalahan saat mengupdate status'
                        });
                    }
                });
            });

            // Reset select if modal is closed without saving
            $('#statusModal').on('hidden.bs.modal', function() {
                $('.status-update').each(function() {
                    $(this).val($(this).data('current'));
                });
            });
        });
    </script>
@endsection
