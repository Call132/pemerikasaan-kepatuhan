<?php

namespace App\Http\Controllers;

use App\Exports\KertasPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class kertasPemeriksaanController extends Controller
{

    public function dashboard()
    {
        // Ambil data perencanaan dan relasikan dengan BadanUsaha
        $perencanaan = perencanaan::all();
        $badanUsaha = BadanUsaha::all();


        // Then, return a view
        return view('kertas-kerja', compact('perencanaan', 'badanUsaha'));
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

        if ($kategori == 'final') {
            $badanUsaha = BadanUsaha::where('jenis_pemeriksaan', 'kantor')->get();
        }

        return view('kertas-kerja', compact('badanUsaha', 'perencanaan'));

        //return redirect()->route('pengiriman-surat')->withInput($request->all())->with(['badanUsaha' => $badanUsaha, 'perencanaan' => $perencanaan, 'periode_pemeriksaan' => $start_date]);
    }
    public function previewKKP($id)
{
    // Ambil data Badan Usaha berdasarkan $id
    $badanUsaha = BadanUsaha::find($id);

    // Kembalikan tampilan "preview kkp" dengan data Badan Usaha
    return view('preview-kkp', compact('badanUsaha'));
}
public function download($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        
        
        return Excel::download(new KertasPemeriksaan($badanUsaha), 'Kertas Kerja Pemeriksaan.xlsx');
    }
}
