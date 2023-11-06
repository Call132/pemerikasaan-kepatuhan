<?php

namespace App\Http\Controllers;

use App\Exports\lhpa;
use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\lhpa as ModelsLhpa;
use App\Models\perencanaan;
use App\Models\sphp;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('sphp', compact('badanUsaha', 'perencanaan'));
    }
    public function cariSphp(Request $request)
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
        return view('sphp', compact('badanUsaha', 'perencanaan'));
    }
    public function formSphp($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();
        return view('form-sphp', compact('badanUsaha', 'spt'));
    }
    public function storeSphp(Request $request)
    {
        $request->validate([
            'badan_usaha_id' => 'required',
            'no_sphp' => 'required',
            'tgl_sphp' => 'required',
            'p-a' => 'required',
            'p-b' => 'required',
            'p-c' => 'required',
        ]);

        $badanUsaha = BadanUsaha::findOrFail($request->badan_usaha_id);
        $sphp = new sphp();
        $sphp->no_sphp = $request->input('no_sphp');
        $sphp->tgl_sphp = $request->input('tgl_sphp');
        $sphp->p_a = $request->input('p-a');
        $sphp->p_b = $request->input('p-b');
        $sphp->p_c = $request->input('p-c');
        $sphp->badan_usaha_id = $request->input('badan_usaha_id');
        $spt = SuratPerintahTugas::latest()->first();

        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

        $sphp->save();


        $pdf = Pdf::loadView('sphp-preview', compact('sphp', 'badanUsaha', 'spt', 'employee'));

        $pdfFileName = 'Surat Pemberitahuan Hasil Pemeriksaan' . $badanUsaha->nama_badan_usaha . '.pdf';

        return $pdf->download($pdfFileName);
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

        $lhpa = new ModelsLhpa();
        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $lhpa->badan_usaha_id = $request->input('bu_id');
        $spt = $request->input('spt_id');
        $jumlahTunggakan = $request->input('jumlah_tunggakan');
        $lhpa->jumlah_bulan_menunggak = $request->input('bulan_menunggak');
        $lhpa->jumlah_pekerja = $request->input('jumlah_pekerja');
        $lhpa->last_year_bulan = $request->input('tmtLastYearBulan');
        $lhpa->last_year_nominal = $request->input('tmtLastYearNominal');
        $lhpa->last_year_pembayaran = $request->input('tmtLastyearPembayaran');
        $lhpa->this_year_bulan = $request->input('thisYearBulan');
        $lhpa->this_year_nominal = $request->input('thisYearNominal');
        $lhpa->this_year_pembayaran = $request->input('thisYearPembayaran');
        $lhpa->tgl_lhpa = Carbon::now()->format('Y-m-d');

        $lhpa->tindak_lanjut = $request->input('tindak_lanjut');
        $lhpa->rekomendasi_pemeriksa = $request->input('rekomendasi_pemeriksa');

        if (empty($lhpa->last_year_bulan)) {
            $lhpa->last_year_bulan = 0;
        }
        if (empty($lhpa->last_year_nominal)) {
            $lhpa->last_year_nominal = 0;
        }
        if (empty($lhpa->last_year_pembayaran)) {
            $lhpa->last_year_pembayaran = 0;
        }
        if (empty($lhpa->this_year_bulan)) {
            $lhpa->this_year_bulan = 0;
        }
        if (empty($lhpa->this_year_nominal)) {
            $lhpa->this_year_nominal = 0;
        }
        if (empty($lhpa->this_year_pembayaran)) {
            $lhpa->this_year_pembayaran = 0;
        }

        $lhpa->save();

        
        return Excel::download(
            new lhpa(
                $badanUsaha,
                $spt,
                $lhpa,
            ),
            'LAPORAN HASIL PEMERIKSAAN AKHIR ' . $badanUsaha->nama_badan_usaha . '.xlsx'
        );
    }
}
