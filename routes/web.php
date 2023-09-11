<?php

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

Route::get('/', function () {
    return view('home' , ['type_menu' => 'dashboard']);
});
Route::get('/create-data-pemeriksaan', function () {
    return view('create-data-pemeriksaan' , ['type_menu' => 'create-data-pemeriksaan']);
});
Route::get('/login', function () {
    return view('login', ['type_menu' => 'auth']);
});
