<?php

namespace App\Http\Controllers;

use App\Exports\KertasPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class kertasPemeriksaanController extends Controller
{

    public function create()
    {
        // Ambil data perencanaan dan relasikan dengan BadanUsaha
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        // Then, return a view
        return view('kertas-kerja', compact('badanUsaha', 'perencanaan'));
    }

    public function form($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $jadwal_pemeriksaan = Carbon::parse($badanUsaha->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');

        return view('form-kertas-kerja', compact('badanUsaha', 'jadwal_pemeriksaan'));
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
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'bu_id' => 'required',
            'npwp' => 'required',
            'ref_pekerja' => 'required',
            'pemeriksa' => 'required',
            'master_file' => 'required',
            'koreksi' => 'required',
            'ref_iuran' => 'required',
            'total_pekerja' => 'required',
            'jumlah_bulan_menunggak' => 'required',
        ]);
        if ($validator) {
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $npwp = $request->input('npwp');
            $refPekerja = $request->input('ref_pekerja');
            $pemeriksa = $request->input('pemeriksa');
            $master_file = $request->input('master_file');
            $koreksi = $request->input('koreksi');
            $refIuran = $request->input('ref_iuran');
            $totalPekerja = $request->input('total_pekerja');
            $bulanMenunggak = $request->input('jumlah_bulan_menunggak');

            return Excel::download(new KertasPemeriksaan($badanUsaha, $npwp, $refPekerja, $pemeriksa, $master_file, $koreksi, $refIuran, $totalPekerja, $bulanMenunggak), 'Kertas Kerja Pemeriksaan.xlsx');
        }
    }
}
