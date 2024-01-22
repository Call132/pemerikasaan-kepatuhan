<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pengirimanController extends Controller
{

    public function index(Request $request)
    {
        $perencanaan = Perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');

        if ($periodePemeriksaan) {

            $perencanaanId = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->value('id');

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
        } else {
            $badanUsaha = BadanUsaha::all();
        }

        return view('pages.pengirimanSurat.index', compact('badanUsaha', 'perencanaan'));
    }
}
