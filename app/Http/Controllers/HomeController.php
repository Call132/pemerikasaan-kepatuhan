<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $badanUsaha = BadanUsaha::all();
       
        
    
        return view('home', ['type_menu' => 'dashboard', 'badanUsaha' => $badanUsaha]); 
    }
}
