<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhistlePengaduan;
use App\Models\RefKategoriPengaduan;
use App\Models\WhistleRiwayat;
use App\Models\WhistleLampiran;
use App\Models\WhistlePihakTerlibat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WhistleblowerExport;

class WhistleblowerAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Tidak perlu middleware tambahan karena sudah di-handle di route level
    }

    /**
     * Display a listing of all reports for admin.
     */
    public function index(Request $request)
    {
        $query = WhistlePengaduan::with(['kategori', 'pelapor'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_pengaduan', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_pengaduan_id', $request->kategori);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->tanggal_selesai);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_pengaduan', 'ilike', "%{$search}%")
                  ->orWhere('kode_pengaduan', 'ilike', "%{$search}%")
                  ->orWhere('uraian_pengaduan', 'ilike', "%{$search}%");
            });
        }

        // Filter berdasarkan unit kerja untuk Admin Prodi
        if (session('selected_role') == 'Admin PPKPT Prodi') {
            $unitKerjaId = session('selected_filter');
            $query->whereHas('pelapor', function($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            });
        }

        $pengaduan = $query->paginate(15);

        // Statistik untuk dashboard
        $stats = [
            'total' => WhistlePengaduan::count(),
            'pending' => WhistlePengaduan::where('status_pengaduan', 'pending')->count(),
            'proses' => WhistlePengaduan::where('status_pengaduan', 'proses')->count(),
            'selesai' => WhistlePengaduan::where('status_pengaduan', 'selesai')->count(),
            'anonim' => WhistlePengaduan::where('anonymous', true)->count(),
            'bulan_ini' => WhistlePengaduan::whereMonth('tanggal_pengaduan', now()->month)
                ->whereYear('tanggal_pengaduan', now()->year)->count(),
        ];

        $kategoris = RefKategoriPengaduan::where('is_active', true)->get();

        return view('whistleblower.Admin.index', compact('pengaduan', 'stats', 'kategoris'));
    }

    /**
     * Dashboard untuk Admin PPKPT
     */
    public function dashboard()
    {
        // Statistik untuk dashboard admin
        $stats = [
            'total' => WhistlePengaduan::count(),
            'pending' => WhistlePengaduan::where('status_pengaduan', 'pending')->count(),
            'proses' => WhistlePengaduan::where('status_pengaduan', 'proses')->count(),
            'selesai' => WhistlePengaduan::where('status_pengaduan', 'selesai')->count(),
            'anonim' => WhistlePengaduan::where('anonymous', true)->count(),
            'bulan_ini' => WhistlePengaduan::whereMonth('tanggal_pengaduan', now()->month)
                ->whereYear('tanggal_pengaduan', now()->year)->count(),
        ];

        // Pengaduan terbaru yang perlu ditangani
        $pengaduan_terbaru = WhistlePengaduan::with(['kategori', 'pelapor'])
            ->whereIn('status_pengaduan', ['pending', 'proses'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik per kategori
        $stats_kategori = RefKategoriPengaduan::withCount(['pengaduan' => function($query) {
            $query->where('is_active', true);
        }])->get();

        // Statistik per bulan (6 bulan terakhir)
        $stats_bulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $stats_bulanan[] = [
                'bulan' => $bulan->format('M Y'),
                'total' => WhistlePengaduan::whereMonth('tanggal_pengaduan', $bulan->month)
                    ->whereYear('tanggal_pengaduan', $bulan->year)
                    ->count()
            ];
        }

        // Statistik berdasarkan waktu response
        $response_stats = [
            'under_24h' => WhistlePengaduan::where('status_pengaduan', '!=', 'pending')
                ->whereRaw('EXTRACT(EPOCH FROM (updated_at - created_at)) / 3600 < 24')
                ->count(),
            'under_72h' => WhistlePengaduan::where('status_pengaduan', '!=', 'pending')
                ->whereRaw('EXTRACT(EPOCH FROM (updated_at - created_at)) / 3600 < 72')
                ->count(),
            'over_72h' => WhistlePengaduan::where('status_pengaduan', '!=', 'pending')
                ->whereRaw('EXTRACT(EPOCH FROM (updated_at - created_at)) / 3600 >= 72')
                ->count(),
        ];

        return view('whistleblower.Admin.dashboard', compact('stats', 'pengaduan_terbaru', 'stats_kategori', 'stats_bulanan', 'response_stats'));
    }

    /**
     * Display the specified report for admin.
     */
    public function show($id)
    {
        $pengaduan = WhistlePengaduan::with([
            'kategori', 
            'pelapor', 
            'lampiran', 
            'pihakTerlibat', 
            'riwayat' => function($query) {
                $query->orderBy('created_at', 'desc');
            },
            'riwayat.createdBy'
        ])->findOrFail($id);

        // Cek apakah admin ini memiliki akses ke pengaduan ini
        if (session('selected_role') == 'Admin PPKPT Prodi') {
            $unitKerjaId = session('selected_filter');
            if ($pengaduan->pelapor && $pengaduan->pelapor->unit_kerja_id != $unitKerjaId) {
                abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
            }
        }

        $kategoris = RefKategoriPengaduan::where('is_active', true)->get();

        return view('whistleblower.Admin.show', compact('pengaduan', 'kategoris'));
    }

    /**
     * Update the status of the specified report.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
            'catatan' => 'nullable|string|max:1000',
            'tindak_lanjut' => 'nullable|string|max:2000'
        ]);

        try {
            DB::beginTransaction();

            $pengaduan = WhistlePengaduan::findOrFail($id);
            $oldStatus = $pengaduan->status_pengaduan;
            
            // Update status pengaduan
            $pengaduan->update([
                'status_pengaduan' => $request->status,
                'tanggal_ditangani' => $request->status == 'proses' ? now() : $pengaduan->tanggal_ditangani,
                'tanggal_selesai' => $request->status == 'selesai' ? now() : null,
                'tindak_lanjut' => $request->tindak_lanjut
            ]);

            // Catat riwayat perubahan status
            WhistleRiwayat::create([
                'pengaduan_id' => $pengaduan->id,
                'status_lama' => $oldStatus,
                'status_baru' => $request->status,
                'catatan' => $request->catatan,
                'created_by' => Auth::id(),
                'created_at' => now()
            ]);

            DB::commit();

            // Send notification jika diperlukan
            $this->sendStatusNotification($pengaduan, $request->status);

            $statusText = [
                'pending' => 'Menunggu Review',
                'proses' => 'Dalam Proses', 
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak'
            ];

            return response()->json([
                'success' => true,
                'message' => "Status pengaduan berhasil diubah menjadi: {$statusText[$request->status]}",
                'new_status' => $request->status,
                'status_text' => $statusText[$request->status]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export reports data.
     */
    public function export(Request $request)
    {
        try {
            $query = WhistlePengaduan::with(['kategori', 'pelapor']);

            // Apply same filters as index
            if ($request->filled('status')) {
                $query->where('status_pengaduan', $request->status);
            }

            if ($request->filled('kategori')) {
                $query->where('kategori_pengaduan_id', $request->kategori);
            }

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('tanggal_pengaduan', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('tanggal_pengaduan', '<=', $request->tanggal_selesai);
            }

            // Filter berdasarkan unit kerja untuk Admin Prodi
            if (session('selected_role') == 'Admin PPKPT Prodi') {
                $unitKerjaId = session('selected_filter');
                $query->whereHas('pelapor', function($q) use ($unitKerjaId) {
                    $q->where('unit_kerja_id', $unitKerjaId);
                });
            }

            $pengaduan = $query->orderBy('created_at', 'desc')->get();

            $filename = 'whistleblower_report_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Jika menggunakan Laravel Excel
            // return Excel::download(new WhistleblowerExport($pengaduan), $filename);

            // Alternatif: Return data dalam format JSON untuk frontend processing
            $exportData = $pengaduan->map(function($item) {
                return [
                    'kode_pengaduan' => $item->kode_pengaduan,
                    'judul' => $item->judul_pengaduan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'status' => ucfirst($item->status_pengaduan),
                    'pelapor' => $item->anonymous ? 'Anonim' : ($item->pelapor->name ?? '-'),
                    'tanggal_pengaduan' => $item->tanggal_pengaduan->format('d/m/Y H:i'),
                    'tanggal_ditangani' => $item->tanggal_ditangani ? $item->tanggal_ditangani->format('d/m/Y H:i') : '-',
                    'tanggal_selesai' => $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y H:i') : '-',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $exportData,
                'filename' => $filename,
                'total_records' => $pengaduan->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download lampiran file (admin access).
     */
    public function downloadLampiran($id)
    {
        try {
            $lampiran = WhistleLampiran::findOrFail($id);
            
            // Cek apakah file ada
            if (!Storage::disk('public')->exists($lampiran->path_file)) {
                abort(404, 'File tidak ditemukan.');
            }

            $path = storage_path('app/public/' . $lampiran->path_file);
            
            return response()->download($path, $lampiran->nama_file);

        } catch (\Exception $e) {
            abort(404, 'File tidak dapat diunduh.');
        }
    }

    /**
     * Manajemen kategori pengaduan
     */
    public function kategori()
    {
        $kategoris = RefKategoriPengaduan::withCount('pengaduan')->get();
        return view('whistleblower.Admin.kategori', compact('kategoris'));
    }

    /**
     * Store new kategori
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kategori_pengaduan,nama',
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        RefKategoriPengaduan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.'
        ]);
    }

    /**
     * Update kategori
     */
    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kategori_pengaduan,nama,' . $id,
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $kategori = RefKategoriPengaduan::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
            'updated_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate.'
        ]);
    }

    /**
     * Delete kategori
     */
    public function destroyKategori($id)
    {
        try {
            $kategori = RefKategoriPengaduan::findOrFail($id);
            
            // Cek apakah kategori masih digunakan
            if ($kategori->pengaduan()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan dalam pengaduan.'
                ], 400);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori.'
            ], 500);
        }
    }

    /**
     * Settings page
     */
    public function settings()
    {
        // Load settings dari database atau config
        $settings = [
            'auto_assign' => config('whistleblower.auto_assign', false),
            'response_time_limit' => config('whistleblower.response_time_limit', 72),
            'allow_anonymous' => config('whistleblower.allow_anonymous', true),
            'max_file_size' => config('whistleblower.max_file_size', 15360),
            'allowed_file_types' => config('whistleblower.allowed_file_types', 'pdf,doc,docx,jpg,jpeg,png'),
        ];

        return view('whistleblower.Admin.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'response_time_limit' => 'required|integer|min:1|max:168',
            'max_file_size' => 'required|integer|min:1024|max:51200',
            'allowed_file_types' => 'required|string'
        ]);

        // Update settings ke database atau config
        // Implementation depends on how you store settings

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan.'
        ]);
    }

    /**
     * Get statistics for charts
     */
    public function getStatistics(Request $request)
    {
        $period = $request->get('period', '6m'); // 6m, 1y, 2y

        $months = $period == '1y' ? 12 : ($period == '2y' ? 24 : 6);
        
        $stats = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $stats[] = [
                'period' => $date->format('M Y'),
                'total' => WhistlePengaduan::whereMonth('tanggal_pengaduan', $date->month)
                    ->whereYear('tanggal_pengaduan', $date->year)->count(),
                'pending' => WhistlePengaduan::whereMonth('tanggal_pengaduan', $date->month)
                    ->whereYear('tanggal_pengaduan', $date->year)
                    ->where('status_pengaduan', 'pending')->count(),
                'selesai' => WhistlePengaduan::whereMonth('tanggal_pengaduan', $date->month)
                    ->whereYear('tanggal_pengaduan', $date->year)
                    ->where('status_pengaduan', 'selesai')->count(),
            ];
        }

        return response()->json($stats);
    }

    /**
     * Send notification saat status berubah
     */
    private function sendStatusNotification($pengaduan, $newStatus)
    {
        // Implementation untuk mengirim notifikasi
        // Bisa via email, SMS, atau push notification
        
        if (!$pengaduan->anonymous && $pengaduan->pelapor) {
            // Send email notification
            // Mail::to($pengaduan->pelapor->email)->send(new StatusUpdatedMail($pengaduan, $newStatus));
        }
    }

    /**
     * Assign pengaduan ke admin tertentu
     */
    public function assignPengaduan(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $pengaduan = WhistlePengaduan::findOrFail($id);
        $pengaduan->update([
            'assigned_to' => $request->assigned_to,
            'assigned_at' => now(),
            'assigned_by' => Auth::id()
        ]);

        WhistleRiwayat::create([
            'pengaduan_id' => $pengaduan->id,
            'status_lama' => $pengaduan->status_pengaduan,
            'status_baru' => $pengaduan->status_pengaduan,
            'catatan' => 'Pengaduan di-assign ke ' . $pengaduan->assignedTo->name,
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil di-assign.'
        ]);
    }
}