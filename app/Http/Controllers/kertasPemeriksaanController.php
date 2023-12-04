<?php

namespace App\Http\Controllers;

use App\Exports\KertasPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\bapket;
use App\Models\kertasKerja;
use App\Models\perencanaan;
use App\Models\surat;
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


        return view('form-kertas-kerja', compact('badanUsaha', 'jadwal_pemeriksaan',));
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
        try {
            $request->validate([
                'bu_id' => 'required',
                'npwp' => 'required',
                'uraian' => 'required',
                'tanggapan_bu' => 'required',
                'ref_pekerja' => 'nullable',
                'pemeriksa' => 'required',
                'master_file' => 'nullable',
                'koreksi' => 'nullable',
                'ref_iuran' => 'nullable',
                'total_pekerja' => 'required',
                'jumlah_bulan_menunggak' => 'required',
            ]);
            $kertasKerja = new kertasKerja();
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $perencanaanId = $badanUsaha->perencanaan_id;

            $kertasKerja->badan_usaha_id = $request->input('bu_id');
            $kertasKerja->badanUsaha->npwp = $request->input('npwp');
            $kertasKerja->uraian = $request->input('uraian');
            $kertasKerja->tanggapan_bu = $request->input('tanggapan_bu');
            $kertasKerja->ref_pekerja = $request->input('ref_pekerja');
            $pemeriksa = $request->input('pemeriksa');
            $kertasKerja->master_file = $request->input('master_file');
            $kertasKerja->koreksi = $request->input('koreksi');
            $kertasKerja->ref_iuran = $request->input('ref_iuran');
            $kertasKerja->total_pekerja = $request->input('total_pekerja');
            $kertasKerja->badanUsaha->jumlah_bulan_menunggak = $request->input('jumlah_bulan_menunggak');
            $kertasKerja->badanUsaha->save();
            $kertasKerja->save();
            $excelFileName = 'Kertas Kerja Pemeriksaan ' . ' ' . $badanUsaha->nama_badan_usaha . ' ' . Carbon::parse($kertasKerja->created_at)->isoFormat('MMMM Y')  . '.xlsx';

            Excel::store(new KertasPemeriksaan($badanUsaha, $pemeriksa, $kertasKerja), 'public/excel/' . $excelFileName);
            $excelPath = 'storage/excel/' . $excelFileName;


            $surat = new surat();
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $perencanaanId;
            $surat->tanggal_surat   = Carbon::now();
            $surat->jenis_surat = 'Kertas Kerja Pemeriksaan';
            $surat->nomor_surat = $excelFileName;
            $surat->file_path = $excelPath;

            $surat->save();



            return redirect($excelPath)->with('success', 'Kertas Kerja Pemeriksaan Berhasil Dibuat');
        } catch (\Exception $e) {
            return dd($e);
            return redirect()->back()->with('error', 'Data Tidak Valid');
        }
    }

    public function formBapket($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $timPemeriksa = TimPemeriksa::latest()->first();
        $spt = SuratPerintahTugas::latest()->first();

        return view('form-bapket', compact('badanUsaha', 'timPemeriksa', 'spt',));
    }


    public function storeBapket(Request $request)
    {
        try {
            $validator = $request->validate([
                'bu_id' => 'required',
                'no_bapket' => 'required|unique:bapket',
                'tgl_bapket' => 'required',
                'nama_pemberi_kerja' => 'required',
                'jabatan' => 'required',
                'tunggakanIuran' => 'nullable',
                'bulanMenunggak' => 'required',
                'sebabMenunggak' => 'required',
            ]);

            $bapket = new bapket($validator);

            $id = $request->input('spt_id');
            $bu_id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($bu_id);
            $spt = SuratPerintahTugas::findOrFail($id);
            $bapket->surat_perintah_tugas_id = $id;
            $bapket->badan_usaha_id = $bu_id;
            $timPemeriksa = $spt->timPemeriksa;
            $bapket->nama_pemberi_kerja = $request->input('nama_pemberi_kerja');
            $bapket->jabatan = $request->input('jabatan');
            $badanUsaha->jumlah_tunggakan = ($request->input('tunggakanIuran'));
            $badanUsaha->jumlah_bulan_menunggak = $request->input('bulanMenunggak');
            $bapket->sebab_menunggak = $request->input('sebabMenunggak');
            $bapket->tgl_bapket = $request->input('tgl_bapket');


            $badanUsaha->save();
            $bapket->save();

            $pdf = Pdf::loadView('bapket-preview', compact('badanUsaha', 'timPemeriksa', 'bapket', 'spt'));

            $pdfFileName = 'Berita Acara Pemeriksaan ' . $badanUsaha->nama_badan_usaha . '.pdf';
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));
            $pdfPath = 'storage/pdf/' . $pdfFileName;


            return redirect($pdfPath)->with('success', 'Berita Acara Pemeriksaan Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Tidak Valid');
        }
    }
}
