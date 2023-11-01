<?php

namespace App\Http\Controllers;

use App\Exports\lhpa;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;

class laporanPemeriksaanController extends Controller
{
    public function sphp()
    {
        return view('sphp-preview');
    }

    public function lhpa()
    {
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('lhpa', compact('badanUsaha', 'perencanaan'));
    }

    public function cariLhpa(Request $request)
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
        return view('lhpa', compact('badanUsaha', 'perencanaan'));
    }

    public function formLhpa($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();

        return view('form-lhpa', compact('badanUsaha', 'spt'));
    }

    public function storeLhpa(Request $request)
    {
        $request->validate([
            'bu_id' => 'required',
            'spt_id' => 'required',
            'jumlah_tunggakan' => 'required',
            'bulan_menunggak' => 'required',
            'jumlah_pekerja' => 'required',
            'tindak_lanjut' => 'required',
            'rekomendasi_pemeriksa' => 'required',
        ]);

        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = $request->input('spt_id');
        $jumlahTunggakan = $request->input('jumlah_tunggakan');
        $bulanMenunggak = $request->input('bulan_menunggak');
        $jumlahPekerja = $request->input('jumlah_pekerja');
        $tindakLanjut = $request->input('tindak_lanjut');
        $rekomendasiPemeriksa = $request->input('rekomendasi_pemeriksa');

        return Excel::download(
            new lhpa(
                $badanUsaha,
                $jumlahTunggakan,
                $bulanMenunggak,
                $jumlahPekerja,
                $tindakLanjut,
                $spt,
                $rekomendasiPemeriksa,
            ),
            'LAPORAN HASIL PEMERIKSAAN AKHIR ' . $badanUsaha->nama_badan_usaha . '.xlsx'
        );
    }
}
