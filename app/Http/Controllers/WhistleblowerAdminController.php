<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhistlePengaduan;
use App\Models\RefKategoriPengaduan;
use App\Models\WhistleRiwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WhistleblowerAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Nanti bisa ditambahkan middleware untuk cek role admin PPKPT
        // $this->middleware('checkPPKTRole');
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

        $kategoris = RefKategoriPengaduan::all();

        return view('admin.whistleblower.index', compact('pengaduan', 'stats', 'kategoris'));
    }

    /**
     * Show dashboard with statistics and charts.
     */
    public function dashboard()
    {
        // Statistik umum
        $stats = [
            'total' => WhistlePengaduan::count(),
            'pending' => WhistlePengaduan::where('status_pengaduan', 'pending')->count(),
            'proses' => WhistlePengaduan::where('status_pengaduan', 'proses')->count(),
            'selesai' => WhistlePengaduan::where('status_pengaduan', 'selesai')->count(),
            'anonim' => WhistlePengaduan::where('anonymous', true)->count(),
        ];

        // Statistik per bulan (6 bulan terakhir)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyStats[] = [
                'bulan' => $date->format('M Y'),
                'total' => WhistlePengaduan::whereMonth('tanggal_pengaduan', $date->month)
                    ->whereYear('tanggal_pengaduan', $date->year)->count(),
            ];
        }

        // Statistik per kategori
        $kategoriStats = RefKategoriPengaduan::withCount('pengaduan')->get();

        // Pengaduan terbaru (pending)
        $pengaduanTerbaru = WhistlePengaduan::with(['kategori', 'pelapor'])
            ->where('status_pengaduan', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.whistleblower.dashboard', compact(
            'stats', 
            'monthlyStats', 
            'kategoriStats', 
            'pengaduanTerbaru'
        ));
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
            'riwayat.updatedBy'
        ])->findOrFail($id);

        return view('admin.whistleblower.show', compact('pengaduan'));
    }

    /**
     * Update the status of the specified report.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
            'catatan' => 'nullable|string|max:1000'
        ]);

        try {
            $pengaduan = WhistlePengaduan::findOrFail($id);
            $oldStatus = $pengaduan->status_pengaduan;
            
            // Update status
            $pengaduan->update([
                'status_pengaduan' => $request->status
            ]);

            // Catat riwayat perubahan status
            WhistleRiwayat::create([
                'pengaduan_id' => $pengaduan->id,
                'status_riwayat' => $request->status,
                'timestamp' => now(),
                'updated_by' => Auth::id(),
                'catatan' => $request->catatan
            ]);

            $statusText = [
                'pending' => 'Menunggu',
                'proses' => 'Dalam Proses', 
                'selesai' => 'Selesai'
            ];

            return response()->json([
                'success' => true,
                'message' => "Status pengaduan berhasil diubah menjadi: {$statusText[$request->status]}",
                'new_status' => $request->status,
                'status_text' => $statusText[$request->status]
            ]);

        } catch (\Exception $e) {
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
        // Implementation for export functionality
        // Bisa menggunakan Laravel Excel atau format lainnya
        
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

        $pengaduan = $query->get();

        // Return Excel file or CSV
        // Implementation depends on your export library choice
        
        return response()->json([
            'message' => 'Export functionality will be implemented here',
            'total_records' => $pengaduan->count()
        ]);
    }

    /**
     * Download lampiran file (admin access).
     */
    public function downloadLampiran($id)
    {
        $lampiran = \App\Models\WhistleLampiran::findOrFail($id);

        if (!Storage::disk('public')->exists($lampiran->file)) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $lampiran->file);
        return response()->download($path);
    }
}