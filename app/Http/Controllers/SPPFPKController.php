<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;

class SPPFPKController extends Controller
{
    public function create($id)
    {
       $badanUsaha = BadanUsaha::find($id);


       return view('buat-sppfpk' , compact('badanUsaha'));
    }
}
