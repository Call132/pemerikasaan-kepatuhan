<?php

namespace App\Http\Controllers;

use App\Exports\monitoring;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use datatables;

class monitoringController extends Controller
{
    public function index(Request $request)
    {
        $perencanaan = Perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');
        $selectedPerencanaan = null;

        if ($periodePemeriksaan) {

            $selectedPerencanaan = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->first();

            if ($selectedPerencanaan) {
                $perencanaanId = $selectedPerencanaan->id;
                $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
            } else {

                $badanUsaha = collect();
            }
        } else {
            $badanUsaha = BadanUsaha::all();
        }

        return view('pages.monitoring.index', compact('perencanaan', 'badanUsaha', 'selectedPerencanaan'));
    }

    public function export(Request $request)
    {
        $id = $request->route('id');
        Log::info('Export function called with ID: ' . $id);
        try {

            $perencanaan = perencanaan::findOrFail($id);
            $badanUsaha = badanUsaha::where('perencanaan_id', $id)->first();


            $excelFileName = 'Laporan Monitoring ' . Carbon::parse($perencanaan->start_date)->isoFormat('MMMM Y') . '.xlsx';
            Excel::store(new monitoring($badanUsaha, $perencanaan), 'public/excel/' . $excelFileName);
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {

                return redirect($existingSurat->file_path)->with('success', 'Laporan Monitoring sudah ada, langsung didownload');
            }
            $path = 'storage/excel/' . $excelFileName;

            $surat = new surat();
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->tanggal_surat   = Carbon::now();
            $surat->jenis_surat = 'Laporan Hasil Pemeriksaan Sementara';
            $surat->nomor_surat = $excelFileName;
            $surat->file_path = $path;
            $surat->save();

            return redirect($path)->with('success', 'Laporan Monitoring Berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Laporan Monitoring Gagal dibuat' . $e->getMessage());
        }
    }

    public function arsip()
    {

        $surat = Surat::all();


        return view('pages.arsip.index', compact('surat'));
    }
}
