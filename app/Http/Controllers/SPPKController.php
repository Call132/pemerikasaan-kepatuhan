<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\sppk;
use App\Models\BadanUsaha;
use App\Models\TimPemeriksa;
use Illuminate\Http\Request;
use App\Models\employee_roles;
use App\Models\surat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SuratPerintahTugas;
use Exception;
use Illuminate\Support\Facades\Log;

class SPPKController extends Controller
{
    public function create($id)

    {
        try {
            $spt = SuratPerintahTugas::latest()->first();
            $timPemeriksa = $spt->timPemeriksa;
            $badanUsaha = BadanUsaha::find($id);


            return view('pages.pengirimanSurat.kantor.create', compact('badanUsaha', 'timPemeriksa'));
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Surat Perintah Tugas Belum Dibuat');
        }
    }

    public function store(Request $request)
    {
        $badanUsahaId = $request->input('badan_usaha_id');
        $badanUsaha = BadanUsaha::find($badanUsahaId);

        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

        $latestSpt = SuratPerintahTugas::latest()->first();
        $timPemeriksa = $latestSpt->timPemeriksa;
        $namaTimPemeriksa = $timPemeriksa->nama;
        $nppTimPemeriksa = $timPemeriksa->npp;
        try {
            $validate = $request->validate([
                'nomor_sppk' => 'required|unique:sppk',
                'tanggal_surat' => 'required',
                'waktu' => 'required',
                'spt_id' => 'required',
                'badan_usaha_id' => 'required',
            ]);

            $sppk = new sppk($validate);
            $sppk->surat_perintah_tugas_id = $request->input('spt_id');
            $sppk->tanggal_surat = $request->input('tanggal_surat');
            $sppk->badan_usaha_id = $request->input('badan_usaha_id');
            $sppk->perencanaan_id = $badanUsaha->perencanaan_id;


            $pdf = Pdf::loadView('pages.pengirimanSurat.kantor.export', compact('sppk', 'badanUsaha', 'namaTimPemeriksa', 'nppTimPemeriksa', 'employee'));
            $pdfFileName = 'Surat Panggilan Pemeriksaan Kantor ' . str_replace('/', '_', $sppk->nomor_sppk) . '.pdf';
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));
            $pdfPath = 'storage/pdf/' . $pdfFileName;
            $surat = new surat();
            $surat->nomor_surat = $sppk->nomor_sppk;
            $surat->jenis_surat = 'Surat Panggilan Pemeriksaan Kantor';
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->tanggal_surat = $sppk->tanggal_surat;
            $surat->file_path = $pdfPath;
            $surat->save();
            $sppk->save();


            return redirect($pdfPath)->with('success', 'Surat Panggilan Pemeriksaan Kantor Berhasil');
        } catch (\Exception $e) {
            return dd($e);
            return redirect()->back()->with('error', 'Nomor Surat Panggilan Pemeriksaan Kantor sudah ada');
        }
    }
}
