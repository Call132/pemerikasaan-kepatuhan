<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\sppl;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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

        try {
            $validate = $request->validate([
                'nomor_sppl' => 'required|unique:sppl,nomor_sppl',
                'nama' => 'required',
                'noHp' => 'nullable'
            ]);
            $tanggal_surat = Carbon::now();

            $sppl = new sppl($validate);
            $sppl->tanggal_surat = $tanggal_surat;
            $sppl->surat_perintah_tugas_id = $spt->id;
            $sppl->save();


            $pdf = Pdf::loadView('sppl-preview', compact('sppl', 'badanUsaha', 'employee'));
            $pdfFileName = 'Surat Perintah Pemeriksaan Lapangan ' . $sppl->nomor_sppl . '.pdf';
            $pdf->save(storage_path('app/public/sppl/' . $pdfFileName));
            $pdfPath = 'storage/sppl/' . $pdfFileName;
            return redirect($pdfPath)->with('success', 'Surat Perintah Pemeriksaan Lapangan Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nomor Surat Perintah Pemeriksaan Lapangan sudah ada');
        }
    }
}
