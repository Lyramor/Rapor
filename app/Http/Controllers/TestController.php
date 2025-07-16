<?php

namespace App\Http\Controllers;

use App\Models\AKM;
use App\Models\JadwalPerkuliahan;
use App\Models\Mahasiswa;
use App\Models\RoleUser;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use App\Models\KelasKuliah;
use App\Models\Krs;
use App\Models\PresensiKuliah;
use Illuminate\Support\Facades\File;

class TestController extends Controller
{
    public function index()
    {
        // get 5 top mahasiswa
        $listMahasiswa = Mahasiswa::whereHas('user')
            // ->limit(5)
            ->get();

        foreach ($listMahasiswa as $mahasiswa) {
            $unitKerjaId = UnitKerja::where('nama_unit', $mahasiswa->programstudi)->first()->id;

            // update unit_kerja_id pada roleuser
            $roleUser = RoleUser::where('user_id', $mahasiswa->user->id)->first();
            $roleUser->unit_kerja_id = $unitKerjaId;
            $roleUser->save();
            // echo $mahasiswa->nama . ' - ' . $unitKerjaId . '-' . $mahasiswa->programstudi . '<br>';
        }

        return response()->json([
            'message' => 'Success',
            'status' => 200
        ], 200);

        // try {
        //     // Create QR code
        //     $qrCode = QrCode::create('Life is too short to be generating QR codes');

        //     // Create FileWriter
        //     $writer = new PngWriter();

        //     // Write QR code to file
        //     $result = $writer->write($qrCode);

        //     // Validate the result (optional)
        //     // $writer->validateResult($result);

        //     // Set the response header
        //     header('Content-Type: ' . $result->getMimeType());

        //     // Output the QR code file contents
        //     echo $result->getString();

        //     exit; // Stop further execution of PHP code
        // } catch (\Exception $e) {
        //     // Tangani kesalahan jika terjadi
        //     // return $this->sendError($e->getMessage(), [], 500);
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //         'status' => 500
        //     ], 500);
        // }
    }

    // auditData
    public function auditData()
    {
        // $data = JadwalPerkuliahan::where('programstudi', 'S1 Teknik Informatika')
        //     ->orWhere('programstudi', 'S1 Teknik Mesin')
        //     ->orWhere('programstudi', 'S1 Teknik Industri')
        //     ->orWhere('programstudi', 'S1 Teknologi Pangan')
        //     ->orWhere('programstudi', 'S1 Teknik Lingkungan')
        //     ->orWhere('programstudi', 'S1 Perencanaan Wilayah dan Kota')
        //     ->where('periode', '20232')
        //     ->get();

        // return response()->json([
        //     'message' => 'Success',
        //     'data' => $data,
        //     'status' => 200
        // ], 200);

        $kelasKuliah = KelasKuliah::all();

        return response()->json([
            'message' => 'Success',
            'data' => $kelasKuliah,
            'status' => 200
        ], 200);

        // $presensi = PresensiKuliah::where('periodeakademik', '20232')
        //     ->get();

        // return response()->json([
        //     'message' => 'Success',
        //     'data' => $presensi,
        //     'status' => 200
        // ], 200);

        // data presensi
        // $presensi = PresensiKuliah::where('periodeakademik', '20232')
        //     ->where('programstudi', 'S1 Perencanaan Wilayah dan Kota')
        //     ->get();

        // $data = [
        //     'message' => 'Success',
        //     'data' => $presensi,
        //     'status' => 200
        // ];

        // $akm = AKM::where('idperiode', '20232')
        //     ->where(function ($query) {
        //         $query->where('nim', 'ilike', '183%')
        //             ->orWhere('nim', 'ilike', '193%')
        //             ->orWhere('nim', 'ilike', '203%')
        //             ->orWhere('nim', 'ilike', '213%')
        //             ->orWhere('nim', 'ilike', '223%')
        //             ->orWhere('nim', 'ilike', '233%');
        //     })
        //     ->get();

        // $krs = Krs::where('idperiode', '20232')
        //     ->where(function ($query) {
        //         $query->where('nim', 'ilike', '183%')
        //             ->orWhere('nim', 'ilike', '193%')
        //             ->orWhere('nim', 'ilike', '203%')
        //             ->orWhere('nim', 'ilike', '213%')
        //             ->orWhere('nim', 'ilike', '223%')
        //             ->orWhere('nim', 'ilike', '233%');
        //     })
        //     ->get();

        // $data =  [
        //     'message' => 'Success',
        //     'data' => $krs,
        //     'status' => 200
        // ];

        // Konversi data ke format JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Tentukan path dan nama file
        $fileName = 'data.json';
        $filePath = storage_path('app/public/' . $fileName);

        // Simpan data JSON ke file
        File::put($filePath, $jsonData);

        // Mengunduh file JSON
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ])->deleteFileAfterSend(true); // Hapus file setelah didownload
    }

    // helloworld
    public function helloworld()
    {
        return response()->json([
            'message' => 'Hello, world!',
            'status' => 200
        ], 200);
    }
}
