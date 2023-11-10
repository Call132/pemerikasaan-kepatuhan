<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\sppk;
use App\Models\BadanUsaha;
use App\Models\TimPemeriksa;
use Illuminate\Http\Request;
use App\Models\employee_roles;
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


            return view('buat-sppk', compact('badanUsaha', 'timPemeriksa'));
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
                'waktu' => 'required',
                'spt_id' => 'required',
                'badan_usaha_id' => 'required',
            ]);

            $tanggalSurat = Carbon::now();


            $sppk = new sppk($validate);
            $sppk->tanggal_surat = $tanggalSurat;
            $sppk->surat_perintah_tugas_id = $request->input('spt_id');
            $sppk->badan_usaha_id = $request->input('badan_usaha_id');
            $sppk->save();



            $pdf = Pdf::loadView('sppk-preview', compact('sppk', 'badanUsaha', 'namaTimPemeriksa', 'nppTimPemeriksa', 'employee'));
            $pdfFileName = 'Surat Perintah Pemeriksaan Kantor ' . $sppk->nomor_sppk . '.pdf';
            $pdf->save(storage_path('app/public/sppk/' . $pdfFileName));
            $pdfPath = 'storage/sppk/' . $pdfFileName;



            return redirect($pdfPath)->with('success', 'Surat Perintah Pemeriksaan Kantor Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nomor Surat Perintah Pemeriksaan Kantor sudah ada');
        }
    }
}
