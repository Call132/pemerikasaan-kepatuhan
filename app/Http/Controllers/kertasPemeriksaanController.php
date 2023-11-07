<?php

namespace App\Http\Controllers;

use App\Exports\KertasPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\bapket;
use App\Models\kertasKerja;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $lastPaymentDate = $badanUsaha->tanggal_terakhir_bayar;
        $currentDate = Carbon::now()->format('Y-m-d');

        $bulanMenunggak = (new DateTime($lastPaymentDate))->diff((new DateTime($currentDate))->modify('1 month'))->m;

        return view('form-kertas-kerja', compact('badanUsaha', 'jadwal_pemeriksaan', 'bulanMenunggak'));
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

        return view('kertas-kerja', compact('badanUsaha', 'perencanaan'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'bu_id' => 'required',
            'npwp' => 'required',
            'uraian' => 'required',
            'tanggapan_bu' => 'required',
            'ref_pekerja' => 'required',
            'pemeriksa' => 'required',
            'master_file' => 'nullable',
            'koreksi' => 'required',
            'ref_iuran' => 'required',
            'total_pekerja' => 'required',
            'jumlah_bulan_menunggak' => 'required',
        ]);
        $kertasKerja = new kertasKerja();
        $id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($id);
        $kertasKerja->badan_usaha_id = $request->input('bu_id');
        $kertasKerja->npwp = $request->input('npwp');
        $kertasKerja->uraian = $request->input('uraian');
        $kertasKerja->tanggapan_bu = $request->input('tanggapan_bu');
        $kertasKerja->ref_pekerja = $request->input('ref_pekerja');
        $pemeriksa = $request->input('pemeriksa');
        $kertasKerja->master_file = $request->input('master_file');
        $kertasKerja->koreksi = $request->input('koreksi');
        $kertasKerja->ref_iuran = $request->input('ref_iuran');
        $kertasKerja->total_pekerja = $request->input('total_pekerja');
        $kertasKerja->jumlah_bulan_menunggak = $request->input('jumlah_bulan_menunggak');
        $kertasKerja->save();

        return Excel::download(new KertasPemeriksaan($badanUsaha, $pemeriksa, $kertasKerja), 'Kertas Kerja Pemeriksaan ' . $badanUsaha->nama_badan_usaha .  '.xlsx');
    }

    public function formBapket($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $timPemeriksa = TimPemeriksa::latest()->first();
        $spt = SuratPerintahTugas::latest()->first();
        $lastPaymentDate = $badanUsaha->tanggal_terakhir_bayar;
        $currentDate = Carbon::now()->format('Y-m-d');

        $bulanMenunggak = (new DateTime($lastPaymentDate))->diff((new DateTime($currentDate))->modify('1 month'))->m;
        return view('form-bapket', compact('badanUsaha', 'timPemeriksa', 'spt', 'bulanMenunggak'));
    }


    public function storeBapket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spt_id' => 'required',
            'bu_id' => 'required',
            'no_bapket' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tunggakanIuran' => 'required',
            'bulanMenunggak' => 'required',
            'sebabMenunggak' => 'required',
        ]);

        $bapket = new bapket();

        $id = $request->input('spt_id');
        $bu_id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($bu_id);
        $bapket->badan_usaha_id = $request->input('bu_id');
        $spt = SuratPerintahTugas::findOrFail($id);
        $bapket->spt_id = $request->input('spt_id');
        $bapket->no_bapket = $request->input('no_bapket');
        $timPemeriksa = TimPemeriksa::latest()->first();
        $bapket->nama_pemberi_kerja = $request->input('nama');
        $bapket->jabatan = $request->input('jabatan');
        $tunggakanIuran = $request->input('tunggakanIuran');
        $bapket->bulan_menunggak = $request->input('bulanMenunggak');
        $bapket->sebab_menunggak = $request->input('sebabMenunggak');
        $bapket->tgl_bapket = Carbon::now()->format('Y-m-d');

        $bapket->save();
        $pdf = Pdf::loadView('bapket-preview', compact('badanUsaha', 'timPemeriksa', 'bapket', 'spt'));

        $pdfFileName = 'Berita Acara Pemeriksaan ' . $badanUsaha->nama_badan_usaha . '.pdf';


        return $pdf->download($pdfFileName);
    }
}
