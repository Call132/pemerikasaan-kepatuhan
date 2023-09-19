<?php

use App\Exports\BadanUsahaExport;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\HomeController;
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

Route::get('data-pemeriksaan', function () {
    return view('data-pemeriksaan' , ['type_menu' => 'data-pemeriksaan']);
});

Route::post('/tambah-data-bu', [BadanUsahaController::class, 'saveData']);


Route::post('/export-perencanaan-pemeriksaan', [BadanUsahaController::class, 'exportToExcel']);
Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
});
Route::delete('/delete-badan-usaha/{id}', [BadanUsahaController::class, 'delete'])->name('delete.badanusaha');
// Tampilan halaman edit-data-pemeriksaan
Route::get('edit-pemeriksaan', function () {
    return view('edit-data-pemeriksaan' , ['type_menu' => 'edit-data-pemeriksaan']);
});

Route::get('/edit-data-pemeriksaan/{id}', [BadanUsahaController::class, 'edit'])->name('edit-data-pemeriksaan');
Route::put('/update-data-pemeriksaan/{id}', [BadanUsahaController::class, 'update'])->name('update-data-pemeriksaan');




