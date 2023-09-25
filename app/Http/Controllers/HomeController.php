<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(){
        $badanUsaha = BadanUsaha::all();
       
        $badanUsaha->transform(function ($item) {
        $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
        return $item;
    });
        //dd($badanUsaha);
        return view('home', ['type_menu' => 'dashboard', 'badanUsaha' => $badanUsaha]); 
    }
 

}
