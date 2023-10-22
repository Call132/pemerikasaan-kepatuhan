<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\sppl;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SPPLController extends Controller
{
    public function create($id)

    {
        $badanUsaha = BadanUsaha::find($id);
        return view('buat-sppl', compact('badanUsaha'));
    }


    public function store(Request $request)
    {
        $id = $request->input('badan_usaha_id');

        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest('id')->first();
        $employee = employee_roles::where('posisi', 'Kepala Cabang')->value('nama');

        $validate = $request->validate([
            'nomor_sppl' => 'required',
            'nama' => 'required',
            'noHp' => 'nullable'
        ]);
        $tanggal_surat = Carbon::now();

        $sppl = new sppl($validate);
        $sppl->tanggal_surat = $tanggal_surat;
        $sppl->spt_id = $spt->id;
        $sppl->save();

        //return response()->json(['message' => 'success', 'sppl' => $sppl]);



        $pdf = Pdf::loadView('sppl-preview', compact('sppl', 'badanUsaha', 'employee'));
        $pdfFileName = 'Surat Perintah Pemeriksaan Kantor ' . $sppl->nomor_sppl . '.pdf';
        return $pdf->download($pdfFileName);
    }
}
