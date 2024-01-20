<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\ProfileadminController;
use App\Http\Controllers\admin\ManajemenUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\pengirimanController;
use App\Http\Controllers\pengirimanSurat;
use App\Http\Controllers\perencanaanController;
use App\Http\Controllers\programPemeriksaanController;
use App\Http\Controllers\kertasPemeriksaanController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\SPPKController;
use App\Http\Controllers\SPPFPKController;
use App\Http\Controllers\SPPLController;
use App\Http\Controllers\BAPKetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\laporanPemeriksaanController;
use App\Http\Controllers\lhpsController;
use App\Http\Controllers\monitoringController;
use App\Http\Controllers\userController;
use App\Models\BadanUsaha;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('home' , ['type_menu' => 'dashboard', 'HomeController@index' ]);
});*/


Route::middleware(['auth', 'role:Admin,User Approval',])->group(function () {
    Route::resource('/user', userController::class)->names('user');
    Route::post('/approve/{id}', [dashboardController::class, 'approve'])->name('approve');
    Route::post('/reject/{id}', [dashboardController::class, 'reject'])->name('reject');
});

//login and register
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/BadanUsaha/{id}', [BadanUsahaController::class, 'create'])->name('badanusaha.create');
    Route::post('/BadanUsaha/{id}', [BadanUsahaController::class, 'store'])->name('badanusaha.store');
    Route::get('/badanusaha/{id}/edit', [BadanUsahaController::class, 'edit'])->name('badanusaha.edit');
    Route::put('/badanusaha/{id}', [BadanUsahaController::class, 'update'])->name('badanusaha.update');
    Route::delete('/badanusaha/{id}', [BadanUsahaController::class, 'delete'])->name('delete.badanusaha');
    Route::get('/export', [BadanUsahaController::class, 'export'])->name('badanusaha.export');

    //perencanaan pemeriksaan
    Route::get('/perencanaan', [perencanaanController::class, 'create'])->name('perencanaan.create');
    Route::post('/perencanaan', [perencanaanController::class, 'store'])->name('perencanaan.store');

    Route::get('/spt', [SptController::class, 'create'])->name('spt.create');
    Route::post('/spt', [SptController::class, 'store'])->name('spt.store');

    Route::get('/pengiriman-surat', [pengirimanController::class, 'index'])->name('pengiriman-surat.index');
    Route::post('/pengiriman-surat', [pengirimanController::class, 'filter'])->name('pengiriman-surat.filter');

    Route::get('/sppk/{id}', [SppkController::class, 'create'])->name('sppk.create');
    Route::post('/sppk', [SppkController::class, 'store'])->name('sppk.store');

    Route::get('/sppl/{id}', [SPPLController::class, 'create'])->name('sppl.create');
    Route::post('/sppl/save', [SPPLController::class, 'store'])->name('sppl.store');

    Route::get('/sppfpk/{id}', [SPPFPKController::class, 'create'])->name('sppfpk.create');
    Route::post('/sppfpk/save', [SPPFPKController::class, 'store'])->name('sppfpk.store');

    Route::get('/program-pemeriksaan', [programPemeriksaanController::class, 'index'])->name('program-pemeriksaan.index');
    Route::get('/program-pemeriksaan/{id}', [programPemeriksaanController::class, 'create'])->name('program-pemeriksaan.create');
    Route::post('/program-pemeriksaan', [programPemeriksaanController::class, 'store'])->name('program-pemeriksaan.store');

    Route::get('/pelaksanaan-pemeriksaan', [kertasPemeriksaanController::class, 'index'])->name('pelaksanaan-pemeriksaan.index');
    Route::get('/kertas-kerja/{id}', [kertasPemeriksaanController::class, 'createKertasKerja'])->name('kertas-kerja.create');
    Route::post('/kertas-kerja', [kertasPemeriksaanController::class, 'storeKertasKerja'])->name('kertas-kerja.store');

    Route::get('/berita-acara/{id}', [kertasPemeriksaanController::class, 'createBapket'])->name('berita-acara.create');
    Route::post('/berita-acara', [kertasPemeriksaanController::class, 'storeBapket'])->name('berita-acara.store');

    Route::get('/lhps', [LaporanController::class, 'indexLHPS'])->name('lhps.index');
    Route::get('/lhps/{id}', [LaporanController::class, 'createLHPS'])->name('lhps.create');
    Route::post('/lhps', [LaporanController::class, 'storeLHPS'])->name('lhps.store');

    Route::get('/lhpa', [LaporanController::class, 'indexLHPA'])->name('lhpa.index');
    Route::get('/lhpa/{id}', [LaporanController::class, 'createLHPA'])->name('lhpa.create');
    Route::post('/lhpa', [LaporanController::class, 'storeLHPA'])->name('lhpa.store');

    Route::get('/sphp', [LaporanController::class, 'indexSphp'])->name('sphp.index');
    Route::get('/sphp/{id}', [LaporanController::class, 'createSphp'])->name('sphp.create');
    Route::post('/sphp', [LaporanController::class, 'storeSphp'])->name('sphp.store');

    Route::get('/monitoring', [monitoringController::class, 'index'])->name('monitoring.index');
    Route::post('/monitoring/{id}', [monitoringController::class, 'export'])->name('monitoring.export');

    Route::get('/arsip', [monitoringController::class, 'arsip'])->name('arsip.index');




});
