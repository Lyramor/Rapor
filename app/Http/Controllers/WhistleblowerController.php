<?php

namespace App\Http\Controllers;

use App\Models\WhistlePengaduan;
use App\Models\RefKategoriPengaduan;
use App\Models\WhistleLampiran;
use App\Models\WhistlePihakTerlibat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WhistleblowerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's reports.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil pengaduan yang dibuat oleh user yang sedang login
        $pengaduan = WhistlePengaduan::with(['kategori', 'lampiran'])
            ->where('pelapor_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik pengaduan user
        $stats = [
            'total' => WhistlePengaduan::where('pelapor_id', $user->id)->count(),
            'pending' => WhistlePengaduan::where('pelapor_id', $user->id)->where('status_pengaduan', 'pending')->count(),
            'proses' => WhistlePengaduan::where('pelapor_id', $user->id)->where('status_pengaduan', 'proses')->count(),
            'selesai' => WhistlePengaduan::where('pelapor_id', $user->id)->where('status_pengaduan', 'selesai')->count(),
        ];

        return view('whistleblower.index', compact('pengaduan', 'stats'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        $kategoris = RefKategoriPengaduan::all();
        return view('whistleblower.create', compact('kategoris'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'uraian_pengaduan' => 'required|string',
            'kategori_pengaduan_id' => 'required|exists:ref_kategori_pengaduan,id',
            'anonymous' => 'boolean',
            'pihak_terlibat' => 'array',
            'pihak_terlibat.*.nama_lengkap' => 'required|string|max:255',
            'pihak_terlibat.*.jabatan' => 'nullable|string|max:255',
            'lampiran' => 'array|max:5',
            'lampiran.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
            'keterangan_lampiran' => 'array',
        ]);

        try {
            // Create pengaduan
            $pengaduan = WhistlePengaduan::create([
                'judul_pengaduan' => $request->judul_pengaduan,
                'uraian_pengaduan' => $request->uraian_pengaduan,
                'kategori_pengaduan_id' => $request->kategori_pengaduan_id,
                'anonymous' => $request->boolean('anonymous'),
                'pelapor_id' => $request->boolean('anonymous') ? null : Auth::id(),
                'tanggal_pengaduan' => now(),
                'status_pengaduan' => 'pending'
            ]);

            // Save pihak terlibat
            if ($request->has('pihak_terlibat')) {
                foreach ($request->pihak_terlibat as $pihak) {
                    WhistlePihakTerlibat::create([
                        'pengaduan_id' => $pengaduan->id,
                        'nama_lengkap' => $pihak['nama_lengkap'],
                        'jabatan' => $pihak['jabatan'] ?? null,
                    ]);
                }
            }

            // Handle file uploads
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $index => $file) {
                    $originalName = $file->getClientOriginalName();
                    $filename = time() . '_' . $index . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    
                    $path = $file->storeAs('whistleblower/lampiran', $filename, 'public');
                    
                    WhistleLampiran::create([
                        'pengaduan_id' => $pengaduan->id,
                        'file' => $path,
                        'keterangan' => $request->keterangan_lampiran[$index] ?? null,
                    ]);
                }
            }

            $message = $request->boolean('anonymous') 
                ? 'Pengaduan anonim berhasil dikirim dengan kode: ' . $pengaduan->kode_pengaduan
                : 'Pengaduan berhasil dikirim dengan kode: ' . $pengaduan->kode_pengaduan;

            return redirect()->route('whistleblower.index')
                ->with('success', $message)
                ->with('kode_pengaduan', $pengaduan->kode_pengaduan);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaduan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified report.
     */
    public function show($id)
    {
        $pengaduan = WhistlePengaduan::with(['kategori', 'lampiran', 'pihakTerlibat', 'riwayat.updatedBy'])
            ->where('id', $id)
            ->where('pelapor_id', Auth::id())
            ->firstOrFail();

        return view('whistleblower.show', compact('pengaduan'));
    }

    /**
     * Check status by code (for anonymous reports).
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'kode_pengaduan' => 'required|string'
        ]);

        $pengaduan = WhistlePengaduan::with(['kategori', 'riwayat'])
            ->where('kode_pengaduan', $request->kode_pengaduan)
            ->first();

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Kode pengaduan tidak ditemukan.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode_pengaduan' => $pengaduan->kode_pengaduan,
                'judul_pengaduan' => $pengaduan->judul_pengaduan,
                'status_pengaduan' => $pengaduan->status_text,
                'tanggal_pengaduan' => $pengaduan->tanggal_pengaduan->format('d/m/Y H:i'),
                'kategori' => $pengaduan->kategori->nama_kategori,
                'riwayat' => $pengaduan->riwayat->map(function($item) {
                    return [
                        'status' => $item->status_riwayat,
                        'tanggal' => $item->timestamp->format('d/m/Y H:i')
                    ];
                })
            ]
        ]);
    }

    /**
     * Download lampiran file.
     */
    public function downloadLampiran($id)
    {
        $lampiran = WhistleLampiran::whereHas('pengaduan', function($query) {
            $query->where('pelapor_id', Auth::id());
        })->findOrFail($id);

        if (!Storage::disk('public')->exists($lampiran->file)) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $lampiran->file);
        return response()->download($filePath);
    }
}