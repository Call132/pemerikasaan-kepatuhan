<?php

namespace App\Http\Controllers;

use App\Exports\ProgramPemeriksaan;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class programPemeriksaanController extends Controller
{
    public function create()
    {

        $badanUsaha = BadanUsaha::all();

        return view('program-pemeriksaan', compact('badanUsaha'));
    }

    public function download($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        
        
        return Excel::download(new ProgramPemeriksaan($badanUsaha), 'Program Realisasi Pemeriksaan.xlsx');
    }
}
