<?php

namespace App\Http\Controllers;

use App\Exports\lhps;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class lhpsController extends Controller
{
    public function index()
    {
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('lhps', compact('badanUsaha', 'perencanaan'));
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
        return view('lhps', compact('badanUsaha', 'perencanaan'));
    }

    public function form($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();

        return view('form-lhps', compact('badanUsaha', 'spt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bu_id' => 'required',
            'spt_id' => 'required',
            'jumlah_tunggakan' => 'required',
            'bulan_menunggak' => 'required',
            'jumlah_pekerja' => 'required',
            'tanggapan_bu' => 'required',
            'rekomendasi_pemeriksa' => 'required',
        ]);

        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = $request->input('spt_id');
        $jumlahTunggakan = $request->input('jumlah_tunggakan');
        $bulanMenunggak = $request->input('bulan_menunggak');
        $jumlahPekerja = $request->input('jumlah_pekerja');
        $tanggapanBu = $request->input('tanggapan_bu');
        $rekomendasiPemeriksa = $request->input('rekomendasi_pemeriksa');


        return Excel::download(
            new lhps(
                $badanUsaha,
                $jumlahTunggakan,
                $bulanMenunggak,
                $jumlahPekerja,
                $tanggapanBu,
                $rekomendasiPemeriksa,
                $spt
            ),
            'Laporan Hasil Pemeriksaan Sementara ' . $badanUsaha->nama_badan_usaha . '.xlsx'
        );
    }
}
