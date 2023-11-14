<?php

namespace App\Http\Controllers;

use App\Exports\monitoring;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class monitoringController extends Controller
{
    public function index()
    {
        $perencanaan = perencanaan::all();

        return view('monitoring', compact('perencanaan'));
    }
    public function cari(Request $request)
    {
        $request->validate([
            'periode_pemeriksaan' => 'required',
        ]);

        $start_date = $request->input('periode_pemeriksaan');

        // Ambil data Badan Usaha berdasarkan kedua kriteria pencarian
        $perencanaan = perencanaan::where('start_date', 'like', "%" . $start_date . "%")->get();


        foreach ($perencanaan as $p) {
            $p->id;
        }
        $badanUsaha = badanUsaha::where('perencanaan_id', $p->id)->get();
        return view('monitoring', compact('badanUsaha', 'perencanaan', 'p'));
    }

    public function export($id)
    {

        try {

            $perencanaan = perencanaan::findOrFail($id);
            $badanUsaha = badanUsaha::where('perencanaan_id', $id)->first();


            $excelFileName = 'laporan-monitoring-' . $perencanaan->start_date . '.xlsx';
            Excel::store(new monitoring($badanUsaha, $perencanaan), 'public/excel/' . $excelFileName);
            $path = 'storage/excel/' . $excelFileName;

            return redirect($path)->with('success', 'Laporan Monitoring Berhasil dibuat');
        } catch (\Exception $e) {
            return dd();
        }
    }
}
