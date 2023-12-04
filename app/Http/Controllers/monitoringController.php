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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class monitoringController extends Controller
{
    public function index()
    {
        $perencanaan = perencanaan::all();

        return view('monitoring', compact('perencanaan'));
    }
    public function cari(Request $request)
    {
        $request->validate([
            'periode_pemeriksaan' => 'required',
        ]);

        $start_date = $request->input('periode_pemeriksaan');

        // Ambil data Badan Usaha berdasarkan kedua kriteria pencarian
        $perencanaan = perencanaan::where('start_date', 'like', "%" . $start_date . "%")->get();


        foreach ($perencanaan as $p) {
            $p->id;
        }
        $badanUsaha = badanUsaha::where('perencanaan_id', $p->id)->get();
        return view('monitoring', compact('badanUsaha', 'perencanaan', 'p'));
    }

    public function export($id)
    {

        try {

            $perencanaan = perencanaan::findOrFail($id);
            $badanUsaha = badanUsaha::where('perencanaan_id', $id)->first();


            $excelFileName = 'Laporan Monitoring ' . Carbon::parse($perencanaan->start_date)->isoFormat('MMMM Y') . '.xlsx';
            Excel::store(new monitoring($badanUsaha, $perencanaan), 'public/excel/' . $excelFileName);
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {
                // Directly download the file
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
            return redirect()->back()->with('error', 'Laporan Monitoring Gagal dibuat');
        }
    }

    public function arsip()
    {

        $surat = Surat::paginate(10);


        return view('arsip', compact('surat'));
    }
    public function cariArsip(Request $request)
    {
        try {


            $searchTerm = $request->input('search');
            $surat = surat::where('file_path', 'like', "%$searchTerm%")->orderBy('created_at', 'desc')->paginate(10);

            if ($searchTerm == 'semua') {
                $surat = surat::orderBy('created_at', 'desc')->paginate(10);
            }
            if ($surat->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada file yang sesuai dengan pencarian.');
            }

            return view('arsip', compact('surat', 'searchTerm'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencari file.');
        }
    }
}
