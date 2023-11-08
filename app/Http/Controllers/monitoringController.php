<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;

class monitoringController extends Controller
{
    public function index()
    {
        $perencanaan = perencanaan::all();
        $badanUsaha = BadanUsaha::all();
        return view('monitoring', compact('perencanaan', 'badanUsaha'));
    }
}
