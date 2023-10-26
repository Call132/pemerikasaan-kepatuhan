<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\sppfpk;
use App\Models\sppk;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SPPFPKController extends Controller
{
    public function create($id)
    {
        $badanUsaha = BadanUsaha::find($id);
        $timPemeriksa = TimPemeriksa::latest('id')->first();
        $sppk = sppk::latest('id')->first();


        return view('buat-sppfpk', compact('badanUsaha', 'timPemeriksa', 'sppk'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nomor_sppfpk' => 'required',
            'hari_tanggal_pelaksanaan' => 'required|date',
            'waktu' => 'required',
        ]);

        $badanUsahaId = $request->input('badan_usaha_id');
        $sppkId = $request->input('sppk_id');
        $badanUsaha = BadanUsaha::find($badanUsahaId);
        $sppk = sppk::find($sppkId);
        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

        if (!$badanUsaha) {
            return redirect()->back()->with('error', 'Badan Usaha tidak ditemukan.');
        }

        $sppfpk = new Sppfpk();
        $sppfpk->nomor_sppfpk = $request->nomor_sppfpk;
        $badanUsaha->jadwal_pemeriksaan = $request->hari_tanggal_pelaksanaan;

        $badanUsaha->save();
        $sppfpk->waktu = $request->waktu;

        $spt = SuratPerintahTugas::latest('id')->first();
        $timPemeriksa = $spt->timPemeriksa;
        $sppfpk->sppk_id = $sppkId;
        $namaTimPemeriksa = $timPemeriksa->nama;
        $nppTimPemeriksa = $timPemeriksa->npp;
        $tanggalSurat = Carbon::now();
        $sppfpk->tanggal_surat = Carbon::now();
        $sppfpk->save();
        

        $pdf = Pdf::loadView('sppfpk-preview', compact('sppfpk','sppk' ,'badanUsaha', 'employee', 'namaTimPemeriksa', 'nppTimPemeriksa', 'tanggalSurat'));
        $pdfFileName = 'Surat Perintah Pemeriksaan Kantor ' . $sppfpk->nomor_sppfpk . '.pdf';
        return $pdf->download($pdfFileName);

        return redirect()->route('sppfpk.index')->with('success', 'SPPFPK berhasil dibuat!');
    }
}
