<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\sppfpk;
use App\Models\sppk;
use App\Models\surat;
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
        if (!$sppk) {
            return redirect()->route('pengiriman-surat.index')->with('error', 'Surat Panggilan Pemeriksaan Kantor Belum Dibuat');
        }
        return view('pages.pengirimanSurat.final.create', compact('badanUsaha', 'timPemeriksa', 'sppk'));
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
                'nomor_sppfpk' => 'required',
                'tanggal_surat' => 'required',
                'waktu' => 'required',
                'sppk_id' => 'required',
                'badan_usaha_id' => 'required',
                'hari_tanggal_pelaksanaan' => 'required',
            ]);

            $existingSurat = surat::where('nomor_surat', $request->nomor_sppfpk)->first();

            if ($existingSurat) {
                return redirect($existingSurat->file_path)->with('success', 'Surat Pemberitahuan Hasil Pemeriksaan sudah ada!!');
            }

            $badanUsaha->jadwal_pemeriksaan = $request->input('hari_tanggal_pelaksanaan');
            $badanUsaha->save();
            $namaTimPemeriksa = $timPemeriksa->nama;
            $nppTimPemeriksa = $timPemeriksa->npp;

            $sppfpk = new Sppfpk($validate);
            $sppfpk->nomor_sppfpk = $request->input('nomor_sppfpk');
            $sppfpk->sppk_id = $request->input('sppk_id');
            $sppfpk->badan_usaha_id = $request->input('badan_usaha_id');
            $sppfpk->waktu = $request->input('waktu');
            $sppfpk->tanggal_surat = $request->input('tanggal_surat');

            $sppfpk->save();

            $pdf = Pdf::loadView('pages.pengirimanSurat.final.export', compact('sppfpk', 'sppk', 'badanUsaha', 'employee', 'namaTimPemeriksa', 'nppTimPemeriksa'));
            $pdfFileName = 'Surat Panggilan Pemeriksaan Final  ' . str_replace('/', '_', $sppfpk->nomor_sppfpk) . '.pdf';
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));
            $pdfPath = 'storage/pdf/' . $pdfFileName;

            $surat = new surat();
            $surat->nomor_surat = $sppfpk->nomor_sppfpk;
            $surat->jenis_surat = 'Surat Perintah Pemeriksaan Final';
            $surat->tanggal_surat = $sppfpk->tanggal_surat;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->file_path = $pdfPath;
            $surat->save();

            return redirect($pdfPath)->with('success', 'Surat Panggilan Pemeriksaan Final  Berhasil Dibuat');
        } catch (\Exception $e) {
            return dd($e);
            return redirect()->back()->with('error', 'Nomor Surat Panggilan Pemeriksaan Final  Sudah Ada');
        }
    }
}
