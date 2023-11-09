<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Auth\AuthRegisterController;
use App\Http\Controllers\Auth\AuthLoginController;
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
use App\Http\Controllers\laporanPemeriksaanController;
use App\Http\Controllers\lhpsController;
use App\Http\Controllers\monitoringController;
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

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
});



//login and register
Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
})->name('login')->middleware('guest');
Route::post('/login', [AuthLoginController::class, 'login'])->name('user.login');
Route::post('/logout', [AuthLoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', function () {
    return view('register', ['type_menu' => 'auth']);
})->middleware('guest');
Route::post('/register', [AuthRegisterController::class, 'register'])->name('user.register');

Route::get('/monitoring', [monitoringController::class, 'index'])->name('monitoring');

Route::middleware(['auth', 'role:user'])->group(function () {
    //homepage
    Route::get('/', [HomeController::class, 'index']); // Gunakan Controller dan metodenya

    Route::post('/tambah-data-bu', [BadanUsahaController::class, 'saveData']);
    Route::post('/export-perencanaan-pemeriksaan', [BadanUsahaController::class, 'exportToExcel']);

    //setting
    /*Route::get('setting', function () {
        return view('setting', ['type_menu' => 'setting']);
    });*/
    //Route::get('/settings/edit', 'SettingController@edit')->name('setting');
    //Route::put('/settings/update', 'SettingController@update')->name('settings.update');



    //spt
    Route::get('/spt', function () {
        return view('buat-spt', ['type_menu' => 'spt']);
    });
    Route::get('/spt/preview', [SptController::class, 'index']);
    Route::post('/spt/save', [SptController::class, 'storeSpt'])->name('spt.store')->middleware('checkStoreSptCall');

    Route::get('/pengiriman-surat', [pengirimanController::class, 'dashboard'])->name('pengiriman-surat');
    Route::post('/pengiriman-surat', [pengirimanController::class, 'cari'])->name('pengiriman-surat.cari');

    Route::get('/sppk/{id}', [SPPKController::class, 'create'])->name('sppk');
    Route::post('/sppk/save', [SPPKController::class, 'store'])->name('sppk.store');

    Route::get('/sppl/{id}', [SPPLController::class, 'create'])->name('sppl');
    Route::post('/sppl/save', [SPPLController::class, 'store'])->name('sppl.store');

    Route::get('/sppfpk/{id}', [SPPFPKController::class, 'create'])->name('sppfpk');
    Route::post('/sppfpk/save', [SPPFPKController::class, 'store'])->name('sppfpk.store');


    Route::get('/sppfpk/preview', [SPPFPKController::class, 'preview'], function () {
        return view('sppfpk-preview');
    })->name('sppfpk.preview');

    Route::get('/program-pemeriksaan', [programPemeriksaanController::class, 'create'])->name('program-pemeriksaan');
    Route::get('/program-pemeriksaan/form/{id}', [programPemeriksaanController::class, 'form'])->name('program-pemeriksaan.form');
    Route::post('/program-pemeriksaan/download', [ProgramPemeriksaanController::class, 'store'])->name('program-pemeriksaan.store');

    Route::get('/kertas-kerja', [kertasPemeriksaanController::class, 'create'])->name('kertas-kerja');
    Route::post('/kertas-kerja', [kertasPemeriksaanController::class, 'cari'])->name('kertas-kerja.cari');
    Route::get('/kertas-kerja/form/{id}', [kertasPemeriksaanController::class, 'form'])->name('kertas-kerja.form');
    Route::post('/kertas-kerja/download', [kertasPemeriksaanController::class, 'store'])->name('kertas-kerja.store');

    Route::get('/bapket/form/{id}', [kertasPemeriksaanController::class, 'formBapket'])->name('bapket.form');
    Route::post('/bapket/download', [kertasPemeriksaanController::class, 'storeBapket'])->name('bapket.store');

    Route::get('/bapket-preview', [BAPKetController::class, 'preview'])->name('bapket-preview');

    Route::get('/lhps', [lhpsController::class, 'index'])->name('lhps');
    Route::post('/lhps', [lhpsController::class, 'cari'])->name('lhps.cari');
    Route::get('/lhps/form/{id}', [lhpsController::class, 'form'])->name('lhps.form');
    Route::post('/lhps/download', [lhpsController::class, 'store'])->name('lhps.store');

    Route::get('/sphp', [laporanPemeriksaanController::class, 'sphp']);
    Route::post('/sphp', [laporanPemeriksaanController::class, 'cariSphp'])->name('sphp.cari');
    Route::get('/sphp/form/{id}', [laporanPemeriksaanController::class, 'formSphp'])->name('sphp.form');
    Route::post('/sphp/download', [laporanPemeriksaanController::class, 'storeSphp'])->name('sphp.store');

    Route::get('/lhpa', [laporanPemeriksaanController::class, 'lhpa']);
    Route::post('/lhpa', [laporanPemeriksaanController::class, 'cariLhpa'])->name('lhpa.cari');
    Route::get('/lhpa/form/{id}', [laporanPemeriksaanController::class, 'formLhpa'])->name('lhpa.form');
    Route::post('/lhpa/download', [laporanPemeriksaanController::class, 'storeLhpa'])->name('lhpa.store');


    Route::get('data-pemeriksaan', function () {
        return view('data-pemeriksaan', ['type_menu' => 'data-pemeriksaan']);
    });
    //perencanaan pemeriksaan
    Route::get('perencanaan', function () {
        return view('buat-perencanaan', ['type_menu' => 'data-pemeriksaan']);
    });
    Route::post('perencanaan', [perencanaanController::class, 'store'])->name('perencanaan.store');
    Route::delete('/delete-badan-usaha/{id}', [BadanUsahaController::class, 'delete'])->name('delete.badanusaha');

    // Tampilan halaman edit-data-pemeriksaan

    Route::get('/data-pemeriksaan/{perencanaan_id}', [BadanUsahaController::class, 'create'])->name('data-pemeriksaan.create');
    Route::post('/data-pemeriksaan/{perencanaan_id}', [BadanUsahaController::class, 'saveData'])->name('data-pemeriksaan.store');

    Route::get('edit-pemeriksaan', function () {
        return view('edit-data-pemeriksaan', ['type_menu' => 'edit-data-pemeriksaan']);
    });
    Route::get('/edit-data-pemeriksaan/{id}', [BadanUsahaController::class, 'edit'])->name('edit-data-pemeriksaan');
    Route::put('/update-data-pemeriksaan/{id}', [BadanUsahaController::class, 'update'])->name('update-data-pemeriksaan');


    // debugging
    Route::get('/debug', function () {
        return view('sppl-preview');
    });
});
