<?php

namespace App\Http\Controllers;

use App\Exports\lhpa;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use Carbon\Carbon;
use DateTime;
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
        $perencanaan = perencanaan::where('start_date', 'like', "%" . $start_date . "%")->get();


        foreach ($perencanaan as $p) {
            $p->id;
        }

        $badanUsaha = DB::table('badan_usaha')
            ->where('jenis_pemeriksaan', 'like', "%" . $kategori . "%")->where('perencanaan_id', $p->id)->get();

        if ($kategori == 'final') {
            $badanUsaha = BadanUsaha::where('jenis_pemeriksaan', 'kantor')->where('perencanaan_id', $p->id)->get();
        }
        return view('lhpa', compact('badanUsaha', 'perencanaan'));
    }

    public function formLhpa($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();
        $lastPaymentDate = $badanUsaha->tanggal_terakhir_bayar;
        $currentDate = Carbon::now()->format('Y-m-d');

        $bulanMenunggak = (new DateTime($lastPaymentDate))->diff((new DateTime($currentDate))->modify('1 month'))->m;

        return view('form-lhpa', compact('badanUsaha', 'spt', 'bulanMenunggak'));
    }

    public function storeLhpa(Request $request)
    {
        $request->validate([
            'bu_id' => 'required',
            'spt_id' => 'required',
            'jumlah_tunggakan' => 'required',
            'bulan_menunggak' => 'required',
            'jumlah_pekerja' => 'required',
            'tmtLastYearBulan' => 'nullable',
            'tmtLastYearNominal' => 'nullable',
            'tmtLastyearPembayaran' => 'nullable',
            'thisYearBulan' => 'nullable',
            'thisYearNominal' => 'nullable',
            'thisYearPembayaran' => 'nullable',
            'tindak_lanjut' => 'required',
            'rekomendasi_pemeriksa' => 'required',
        ]);

        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = $request->input('spt_id');
        $jumlahTunggakan = $request->input('jumlah_tunggakan');
        $bulanMenunggak = $request->input('bulan_menunggak');
        $jumlahPekerja = $request->input('jumlah_pekerja');
        $lastYearBulan = $request->input('tmtLastYearBulan');
        $lastYearNominal = $request->input('tmtLastYearNominal');
        $lastYearPembayaran = $request->input('tmtLastyearPembayaran');
        $thisYearBulan = $request->input('thisYearBulan');
        $thisYearNominal = $request->input('thisYearNominal');
        $thisYearPembayaran = $request->input('thisYearPembayaran');

        $tindakLanjut = $request->input('tindak_lanjut');
        $rekomendasiPemeriksa = $request->input('rekomendasi_pemeriksa');

        if (empty($lastYearBulan)) {
            $lastYearBulan = 0;
        }
        if (empty($lastYearNominal)) {
            $lastYearNominal = 0;
        }
        if (empty($thisYearBulan)) {
            $thisYearBulan = 0;
        }
        if (empty($thisYearNominal)) {
            $thisYearNominal = 0;
        }
        if (empty($lastYearPembayaran)) {
            $lastYearPembayaran = 0;
        }
        if (empty($thisYearPembayaran)) {
            $thisYearPembayaran = 0;
        }

        return Excel::download(
            new lhpa(
                $badanUsaha,
                $jumlahTunggakan,
                $bulanMenunggak,
                $jumlahPekerja,
                $lastYearBulan,
                $lastYearNominal,
                $lastYearPembayaran,
                $thisYearBulan,
                $thisYearNominal,
                $thisYearPembayaran,
                $tindakLanjut,
                $spt,
                $rekomendasiPemeriksa,
            ),
            'LAPORAN HASIL PEMERIKSAAN AKHIR ' . $badanUsaha->nama_badan_usaha . '.xlsx'
        );
    }
}
