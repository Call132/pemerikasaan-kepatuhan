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

        $spt = SuratPerintahTugas::latest()->first();
        $timPemeriksa = $spt->timPemeriksa;
        $badanUsaha = BadanUsaha::find($id);


        return view('buat-sppk', compact('badanUsaha', 'timPemeriksa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_sppk' => 'required',
            'waktu' => 'nullable',
            'tanggal_surat' => 'nullable',
            'spt_id' => 'required',
        ]);

        try {
            $id = $request->input('badan_usaha_id');
            $badanUsaha = BadanUsaha::find($id);
            $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

            $spt = SuratPerintahTugas::latest()->first();
            $timPemeriksa = $spt->timPemeriksa;
            $namaTimPemeriksa = $timPemeriksa->nama;
            $nppTimPemeriksa = $timPemeriksa->npp;
            $tanggal_surat = Carbon::now();

            $sppk = new sppk();
            $sppk->nomor_sppk = $request->input('nomor_sppk');
            $sppk->waktu = $request->input('waktu');
            $sppk->tanggal_surat = $tanggal_surat;
            $sppk->surat_perintah_tugas_id = $request->input('spt_id');

            $sppk->save();

            $pdf = Pdf::loadView('sppk-preview', compact('sppk', 'badanUsaha', 'namaTimPemeriksa', 'nppTimPemeriksa', 'employee'));
            $pdfFileName = 'Surat Perintah Pemeriksaan Kantor ' . $sppk->nomor_sppk . '.pdf';

            Log::info('PDF generated: ' . $pdfFileName);
            return $pdf->download($pdfFileName);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'error' => 'Nomor SPPK sudah ada dalam basis data. Harap gunakan nomor SPPK yang berbeda.',
                ], 400);
            }
            dd($e);
        }
    }
}
