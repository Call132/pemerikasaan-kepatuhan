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
    public function index(Request $request)
    {
        $perencanaan = Perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');

        if ($periodePemeriksaan) {

            $perencanaanId = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->value('id');

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
        } else {
            $badanUsaha = BadanUsaha::all();
        }
        return view('pages.pelaksanaanPemeriksaan.index', compact('badanUsaha', 'perencanaan'));
    }

    public function createKertasKerja($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $jadwal_pemeriksaan = Carbon::parse($badanUsaha->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');

        return view('pages.pelaksanaanPemeriksaan.kertasKerja.create', compact('badanUsaha', 'jadwal_pemeriksaan',));
    }

    public function storeKertasKerja(Request $request)
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
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {

                return redirect($existingSurat->file_path)->with('success', 'Perencanaan Pemeriksaan sudah ada, langsung didownload');
            }
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

    public function createBapket($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $timPemeriksa = TimPemeriksa::latest()->first();
        $spt = SuratPerintahTugas::latest()->first();

        return view('pages.pelaksanaanPemeriksaan.beritaAcara.create', compact('badanUsaha', 'timPemeriksa', 'spt',));
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

            $pdf = Pdf::loadView('pages.pelaksanaanPemeriksaan.beritaAcara.export', compact('badanUsaha', 'timPemeriksa', 'bapket', 'spt'));

            $pdfFileName = 'Berita Acara Pemeriksaan ' . str_replace('/', ' ', $bapket->no_bapket) . '.pdf';
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));
            $pdfPath = 'storage/pdf/' . $pdfFileName;


            return redirect($pdfPath)->with('success', 'Berita Acara Pemeriksaan Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
