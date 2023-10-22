<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\sppk;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SPPKController extends Controller
{

    public function create($id)

    {

        $timPemeriksa = TimPemeriksa::latest('id')->first();
        $id = BadanUsaha::find($id);
        //dd($this->id);

        return view('buat-sppk', compact('id', 'timPemeriksa'));
    }

    public function store(Request $request)
    {

        $id = $request->input('badan_usaha_id');

        $badanUsaha = BadanUsaha::find($id);

        $spt = SuratPerintahTugas::latest('id')->first();
        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

        $validate = $request->validate([
            'nomor_sppk' => 'required',
            'waktu' => 'nullable',
           
        ]);

        $timPemeriksa = $spt->timPemeriksa;

        $namaTimPemeriksa = $timPemeriksa->nama;
        $nppTimPemeriksa = $timPemeriksa->npp;
        $tanggal_surat = Carbon::now(); // Menggunakan Carbon untuk mendapatkan tanggal saat ini


        $sppk = new sppk($validate);
        $sppk->tanggal_surat = $tanggal_surat;
        $sppk->spt_id = $spt->id;
        $sppk->save();




        $pdf = Pdf::loadView('sppk-preview', compact('sppk', 'badanUsaha', 'namaTimPemeriksa', 'nppTimPemeriksa', 'employee'));

        // Generate a unique filename for the PDF (you can customize this)
        $pdfFileName = 'Surat Perintah Pemeriksaan Kantor ' . $sppk->nomor_sppk . '.pdf';

        // Download the PDF
        return $pdf->download($pdfFileName);
        // redirect ke hallaman lain
        return redirect()->route('pengiriman-surat')->with('success', 'SPPK selesai dibuat');
    }
}
