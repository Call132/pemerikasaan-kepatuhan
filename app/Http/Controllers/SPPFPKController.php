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
use Illuminate\Support\Facades\Log;

class SPPFPKController extends Controller
{
    public function create($id)
    {
        $badanUsaha = BadanUsaha::find($id);
        $sppk = sppk::where('badan_usaha_id', $id)->first();
        $spt = SuratPerintahTugas::latest('id')->first();
        $timPemeriksa = TimPemeriksa::where('surat_perintah_tugas_id', $spt->id)->first();


        return view('buat-sppfpk', compact('badanUsaha', 'timPemeriksa', 'sppk'));
    }
    public function store(Request $request)
    {
        $badanUsahaId = $request->input('badan_usaha_id');
        $sppk = sppk::findOrFail($request->input('sppk_id'));
        $spt = $sppk->surat_perintah_tugas_id;
        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();
        $timPemeriksa = TimPemeriksa::where('surat_perintah_tugas_id', $spt)->first();
        $badanUsaha = BadanUsaha::find($sppk->badan_usaha_id);


        try {
            $validate = $request->validate([
                'nomor_sppfpk' => 'required|unique:sppfpk',
                'waktu' => 'required',
                'sppk_id' => 'required',
                'badan_usaha_id' => 'required',
                'hari_tanggal_pelaksanaan' => 'required',
            ]);
            $badanUsaha->jadwal_pemeriksaan = $request->input('hari_tanggal_pelaksanaan');
            $badanUsaha->save();
            $namaTimPemeriksa = $timPemeriksa->nama;
            $nppTimPemeriksa = $timPemeriksa->npp;

            $sppfpk = new Sppfpk($validate);
            $sppfpk->nomor_sppfpk = $request->input('nomor_sppfpk');
            $sppfpk->sppk_id = $request->input('sppk_id');
            $sppfpk->badan_usaha_id = $request->input('badan_usaha_id');
            $sppfpk->waktu = $request->input('waktu');
            $sppfpk->tanggal_surat = Carbon::now();

            $sppfpk->save();

            $pdf = Pdf::loadView('sppfpk-preview', compact('sppfpk', 'sppk', 'badanUsaha', 'employee', 'namaTimPemeriksa', 'nppTimPemeriksa'));
            $pdfFileName = 'Surat Perintah Pemeriksaan Final Kantor ' . $sppfpk->nomor_sppfpk . '.pdf';
            $pdf->save(storage_path('app/public/sppfpk/' . $pdfFileName));
            $pdfPath = 'storage/sppfpk/' . $pdfFileName;
            return redirect($pdfPath)->with('success', 'Surat Perintah Pemeriksaan Final Kantor Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nomor Surat Perintah Pemeriksaan Final Kantor Sudah Ada');
        }
    }
}
