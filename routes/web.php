<?php

use App\Exports\BadanUsahaExport;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SptController;
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

Route::get('/', [HomeController::class, 'index']); // Gunakan Controller dan metodenya



Route::post('/tambah-data-bu', [BadanUsahaController::class, 'saveData']);
Route::post('/export-perencanaan-pemeriksaan', [BadanUsahaController::class, 'exportToExcel']);

Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
});
Route::get('/spt', function () {
    return view('buat-spt', ['type_menu' => 'spt']);
});
Route::get('/debug', function () {
    $badanUsahaDiajukan = BadanUsaha::where('status', 'Diajukan')->get();
    dd($badanUsahaDiajukan);
});

Route::get('/spt/preview', [SptController::class, 'index']);
//Route::post('/spt/export-Pdf', [SptController::class, 'exportPdf'])->name('spt.exportPdf');
Route::post('/spt/save', [SptController::class, 'store'])->name('spt.store');


Route::get('data-pemeriksaan', function () {
    return view('data-pemeriksaan' , ['type_menu' => 'data-pemeriksaan']);
});
Route::delete('/delete-badan-usaha/{id}', [BadanUsahaController::class, 'delete'])->name('delete.badanusaha');
// Tampilan halaman edit-data-pemeriksaan
Route::get('edit-pemeriksaan', function () {
    return view('edit-data-pemeriksaan' , ['type_menu' => 'edit-data-pemeriksaan']);
});
Route::get('/edit-data-pemeriksaan/{id}', [BadanUsahaController::class, 'edit'])->name('edit-data-pemeriksaan');
Route::put('/update-data-pemeriksaan/{id}', [BadanUsahaController::class, 'update'])->name('update-data-pemeriksaan');




