<?php

namespace App\Http\Controllers;

use App\Exports\lhps;
use App\Models\BadanUsaha;
use App\Models\lhps as ModelsLhps;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use Carbon\Carbon;
use DateTime;
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
        $perencanaan = perencanaan::where('start_date', 'like', "%" . $start_date . "%")->get();


        foreach ($perencanaan as $p) {
            $p->id;
        }

        $badanUsaha = DB::table('badan_usaha')
            ->where('jenis_pemeriksaan', 'like', "%" . $kategori . "%")->where('perencanaan_id', $p->id)->get();

        if ($kategori == 'final') {
            $badanUsaha = BadanUsaha::where('jenis_pemeriksaan', 'kantor')->where('perencanaan_id', $p->id)->get();
        }
        return view('lhps', compact('badanUsaha', 'perencanaan'));
    }

    public function form($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();
        $lastPaymentDate = $badanUsaha->tanggal_terakhir_bayar;
        $currentDate = Carbon::now()->format('Y-m-d');

        $bulanMenunggak = (new DateTime($lastPaymentDate))->diff((new DateTime($currentDate))->modify('1 month'))->m;


        return view('form-lhps', compact('badanUsaha', 'spt', 'bulanMenunggak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bu_id' => 'required',
            'spt_id' => 'required',
            'jumlah_tunggakan' => 'required',
            'bulan_menunggak' => 'required',
            'jumlah_pekerja' => 'required',
            'tmtLastYearBulan' => 'nullable',
            'tmtLastYearNominal' => 'nullable',
            'thisYearBulan' => 'nullable',
            'thisYearNominal' => 'nullable',
            'tanggapan_bu' => 'required',
            'rekomendasi_pemeriksa' => 'required',
        ]);
        $lhps = new ModelsLhps();
        $lhps->tgl_lhps = Carbon::now()->format('Y-m-d');
        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $lhps->badan_usaha_id = $request->input('bu_id');
        $spt = $request->input('spt_id');
        $jumlahTunggakan = $request->input('jumlah_tunggakan');
        $lhps->jumlah_bulan_menunggak = $request->input('bulan_menunggak');
        $lhps->jumlah_pekerja = $request->input('jumlah_pekerja');
        $lhps->last_year_bulan = $request->input('tmtLastYearBulan');
        $lhps->last_year_nominal = $request->input('tmtLastYearNominal');
        $lhps->this_year_bulan = $request->input('thisYearBulan');
        $lhps->this_year_nominal = $request->input('thisYearNominal');
        $lhps->tanggapan_bu = $request->input('tanggapan_bu');
        $lhps->rekomendasi_pemeriksa = $request->input('rekomendasi_pemeriksa');

        if (empty($lhps->last_year_bulan)) {
            $lhps->last_year_bulan = 0;
        }
        if (empty($lhps->last_year_nominal)) {
            $lhps->last_year_nominal = 0;
        }
        if (empty($lhps->this_year_bulan)) {
            $lhps->this_year_bulan = 0;
        }
        if (empty($lhps->this_year_nominal)) {
            $lhps->this_year_nominal = 0;
        }
        $lhps->save();
        

        return Excel::download(
            new lhps(
                $badanUsaha,
                $lhps,
                $spt
            ),
            'Laporan Hasil Pemeriksaan Sementara ' . $badanUsaha->nama_badan_usaha . '.xlsx'
        );
    }
}
