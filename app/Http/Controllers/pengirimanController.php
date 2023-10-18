<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pengirimanController extends Controller
{

    public function dashboard()
    {



        // Ambil data perencanaan dan relasikan dengan BadanUsaha
        $perencanaan = perencanaan::all();
        $badanUsaha = BadanUsaha::all();


        // Then, return a view
        return view('pengiriman-surat', compact('perencanaan', 'badanUsaha'));
    }
    public function cari(Request $request)
    {
        $request->validate([
            'periode_pemeriksaan' => 'required',
            'kategori' => 'required',
        ]);

        $start_date = $request->input('periode_pemeriksaan');
        $kategori = $request->input('kategori');

        // Ambil data Badan Usaha berdasarkan kedua kriteria pencarian
        $perencanaan = perencanaan::all();
        $badanUsaha = DB::table('badan_usaha')
            ->where('jenis_pemeriksaan', 'like', "%" . $kategori . "%")->get();

        return view('pengiriman-surat', compact('badanUsaha', 'perencanaan'));

        //return redirect()->route('pengiriman-surat')->withInput($request->all())->with(['badanUsaha' => $badanUsaha, 'perencanaan' => $perencanaan, 'periode_pemeriksaan' => $start_date]);
    }
}
