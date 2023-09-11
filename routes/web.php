<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


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
Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
});
