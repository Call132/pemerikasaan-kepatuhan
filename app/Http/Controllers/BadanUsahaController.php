<?php

namespace App\Http\Controllers;

use App\Exports\BadanUsahaExport;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BadanUsahaController extends Controller
{
    public function exportToExcel()
{
    return Excel::download(new BadanUsahaExport, 'PERENCANAAN_PEMERIKSAAN.xlsx');

}

}
