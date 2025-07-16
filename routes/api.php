<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/helloworld', function () {
//     return response()->json(['message' => 'Hello, world!']);
// });

// Route::namespace('App\Http\Controllers')->group(function () {
    // Route::prefix('sinkronasi')->group(function () {
    //     Route::get('/', "SinkronasiController@index");
    //     Route::get('/getToken', "SinkronasiController@getToken");
    //     Route::get('/getDataDosen', "SinkronasiController@getDataDosen");
    //     Route::get('/getDataPeriode', "SinkronasiController@getDataPeriode");
    //     Route::get('/getDataKelasKuliah', "SinkronasiController@getDataKelasKuliah");
    // });

    // Route::prefix('rapor')->group(function () {
    //     Route::get('/', "RaporController@index");
    //     Route::get('/rapor-kinerja', "RaporController@getAllDataRapor");
    //     Route::post('/generateDataRapor', "RaporController@generateDataRapor");
    // });

    // Route::prefix('laporan')->group(function () {
    //     Route::post('/generate-laporan-kinerja', "LaporanController@generateLaporanKinerja")->name('laporan.generate');
    // });

    // Route::prefix('unit-kerja')->group(function () {
    //     Route::get('/', "UnitKerjaController@index");
    //     Route::get('/getUnitKerja', "UnitKerjaController@getUnitKerja");
    //     Route::get('/getUnitKerjaByParent', "UnitKerjaController@getUnitKerjaByParent");
    // });

    // Route::prefix('kuesioner')->group(function () {
    //     Route::post('/soalkuesionersdm/store', "KuesionerSDMController@createSoalKuesionerSDM");
    // });
// });
