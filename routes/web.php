<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bpjs\DataInacbg;
use App\Http\Controllers\Bpjs\HomeCasemix;
use App\Http\Controllers\Bpjs\GabungBerkas;
use App\Http\Controllers\Bpjs\BpjsController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Bpjs\ListPasienRalan;
use App\Http\Controllers\Bpjs\ListPasienRanap;
use App\Http\Controllers\Bpjs\CesmikController;
use App\Http\Controllers\Laporan\PasienController;
use App\Http\Controllers\Bpjs\PrintCesmikController;
use App\Http\Controllers\Farmasi\SepResepController;
use App\Http\Controllers\Returobat\ReturObatController;
use App\Http\Controllers\Farmasi\ViewSepResepController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/miantance-laravel-update', [AuthController::class, 'Maintance']);
Route::group(['middleware' => 'default'], function () {
Route::get('/test', [TestController::class, 'Test']);
Route::get('/test-cari', [TestController::class, 'TestCari']);

Route::get('/login', [AuthController::class, 'Login'])->name('login');
Route::post('/mesinlogin', [AuthController::class, 'mesinLogin']);

Route::group(['middleware' => 'auth-rsbw'], function () {
    Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');
    Route::get('/', [PasienController::class, 'Pasien']);

    // OBAT
    Route::get('/returObat', [ReturObatController::class, 'Obat'])->middleware('permision-rsbw:penyakit');
    Route::get('/cariNorm', [ReturObatController::class, 'Obat']);
    Route::get('/print/{id}', [ReturObatController::class, 'Print']);

    // CASEMIX
    Route::get('/list-pasein-ralan', [ListPasienRalan::class, 'lisPaseinRalan']);
    Route::get('/cari-list-pasein-ralan', [ListPasienRalan::class, 'cariListPaseinRalan']);

    Route::get('/list-pasein-ranap', [ListPasienRanap::class, 'lisPaseinRanap']);
    Route::get('/cari-list-pasein-ranap', [ListPasienRanap::class, 'cariListPaseinRanap']);

    Route::get('/casemix-home', [HomeCasemix::class, 'casemixHome']);
    Route::get('/casemix-home-cari', [HomeCasemix::class, 'casemixHomeCari']);

    Route::get('/cariNorawat-ClaimBpjs', [BpjsController::class, 'claimBpjs']);
    Route::post('/upload-berkas', [BpjsController::class, 'inputClaimBpjs']);

    Route::get('/carinorawat-casemix', [CesmikController::class, 'Casemix']);
    Route::get('/print-casemix', [PrintCesmikController::class, 'printCasemix']);

    Route::get('/gabung-berkas-casemix', [GabungBerkas::class, 'gabungBerkas']);

    Route::get('/data-inacbg', [DataInacbg::class, 'Inacbg']);

    // FARMASI
    Route::get('/list-pasien-farmasi', [SepResepController::class, 'ListPasienFarmasi']);
    Route::get('/cari-list-pasien-farmasi', [SepResepController::class, 'CariListPasienFarmasi']);

    Route::get('/view-sep-resep', [ViewSepResepController::class, 'ViewBerkasSepResep']);
    Route::get('/print-sep-resep', [ViewSepResepController::class, 'PrintBerkasSepResep']);
    Route::post('/upload-berkas-farmasi', [ViewSepResepController::class, 'UploadBerkasFarmasi']);
});
});

