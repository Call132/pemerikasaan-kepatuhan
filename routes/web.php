<?php

use App\Exports\BadanUsahaExport;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\perencanaanController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\SPPKController;
use App\Http\Controllers\SPPFPKController;
use App\Http\Controllers\SPPLController;
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

//homepage
Route::get('/', [HomeController::class, 'index']); // Gunakan Controller dan metodenya

Route::post('/tambah-data-bu', [BadanUsahaController::class, 'saveData']);
Route::post('/export-perencanaan-pemeriksaan', [BadanUsahaController::class, 'exportToExcel']);

//setting
Route::get('setting', function () {
    return view('setting', ['type_menu' => 'setting']);
});
Route::get('/settings/edit', 'SettingController@edit')->name('setting');
Route::put('/settings/update', 'SettingController@update')->name('settings.update');



//login and register
Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
});
Route::get('/spt', function () {
    return view('buat-spt', ['type_menu' => 'spt']);
});
Route::get('/sppk', function () {
    return view('buat-sppk', ['type_menu' => 'sppk']);
});
Route::get('/sppfpk', function () {
    return view('buat-sppfpk', ['type_menu' => 'sppfpk']);
});
Route::get('/sppl', function () {
    return view('buat-sppl', ['type_menu' => 'sppl']);
});
Route::get('/debug', function () {
    $badanUsahaDiajukan = BadanUsaha::where('status', 'Diajukan')->get();
    dd($badanUsahaDiajukan);
});
Route::get('/sppk/preview', [SPPKController::class, 'preview'])->name('sppk-preview');
Route::get('/sppfpk/preview', [SPPFPKController::class, 'preview'])->name('sppfpk-preview');
Route::get('/sppl/preview', [SPPLController::class, 'preview'])->name('sppl-preview');



Route::get('/spt/preview', [SptController::class, 'index']);
//Route::post('/spt/export-Pdf', [SptController::class, 'exportPdf'])->name('spt.exportPdf');
Route::post('/spt/save', [SptController::class, 'store'])->name('spt.store');


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


//spt
Route::get('/spt', function () {
    return view('buat-spt', ['type_menu' => 'spt']);
});
Route::get('/spt/preview', [SptController::class, 'index']);
//Route::get('/spt/preview', [SptController::class, 'store'])->name('spt.preview');
//Route::post('/spt/export-Pdf', [SptController::class, 'exportPdf'])->name('spt.exportPdf');
Route::post('/spt/save', [SptController::class, 'store'])->name('spt.create');


// debugging
Route::get('/debug', function () {
    $badanUsahaDiajukan = BadanUsaha::where('status', 'Diajukan')->get();
    dd($badanUsahaDiajukan);
});
