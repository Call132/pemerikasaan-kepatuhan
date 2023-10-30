<?php

namespace App\Http\Controllers;

use App\Exports\KertasPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

    public function formBapket($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $timPemeriksa = TimPemeriksa::latest()->first();
        $spt = SuratPerintahTugas::latest()->first();
        return view('form-bapket', compact('badanUsaha', 'timPemeriksa', 'spt'));
    }


    public function storeBapket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spt_id' => 'required',
            'bu_id' => 'required',
            'timPemeriksa' => 'required',
            'timPemeriksaNpp' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tunggakanIuran' => 'required',
            'bulanMenunggak' => 'required',
            'sebabMenunggak' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $id = $request->input('spt_id');
        $bu_id = $request->input('bu_id');
        $badanUsaha = BadanUsaha::findOrFail($bu_id);
        $spt = SuratPerintahTugas::findOrFail($id);
        $timPemeriksa = TimPemeriksa::latest()->first();
        $nama = $request->input('nama');
        $jabatan = $request->input('jabatan');
        $tunggakanIuran = $request->input('tunggakanIuran');
        $bulanMenunggak = $request->input('bulanMenunggak');
        $sebabMenunggak = $request->input('sebabMenunggak');
    
        $pdf = Pdf::loadView('bapket-preview', compact('badanUsaha','timPemeriksa' ,'spt', 'nama', 'jabatan', 'tunggakanIuran', 'bulanMenunggak', 'sebabMenunggak'));

        $pdfFileName = 'Berita Acara Pemeriksaan ' . $badanUsaha->nama_badan_usaha . '.pdf';

        return $pdf->download($pdfFileName);
    }
}
