<?php

namespace App\Http\Controllers;

use App\Exports\monitoring;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
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


            $excelFileName = 'Laporan Monitoring ' . $perencanaan->start_date . '.xlsx';
            Excel::store(new monitoring($badanUsaha, $perencanaan), 'public/excel/' . $excelFileName);
            $path = 'storage/excel/' . $excelFileName;

            return redirect($path)->with('success', 'Laporan Monitoring Berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Laporan Monitoring Gagal dibuat');
        }
    }

    public function arsip()
    {
        $files = Storage::allFiles('public');

        return view('arsip', compact('files'));
    }
    public function cariArsip(Request $request)
    {
        try {
           

            $searchTerm = $request->input('search');
            $files = Storage::allFiles('public');
            if ($searchTerm == 'semua') {
                $filteredFiles = $files;
            } else {
                $filteredFiles = $this->filterFilesByName($files, $searchTerm);
            }
            if (empty($filteredFiles)) {
                return redirect()->back()->with('error', 'Tidak ada file yang sesuai dengan pencarian.');
            }

            return view('arsip', compact('filteredFiles', 'searchTerm'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencari file.');
        }
    }
    private function filterFilesByName($files, $searchTerm)
    {
        return array_filter($files, function ($file) use ($searchTerm) {
            return stripos($file, $searchTerm) !== false;
        });
    }

    private function filterFilesByFile(array $files, $searchTerm)
    {
        // Filter files based on search term
        $filteredFiles = collect(array_filter($files, function ($file) use ($searchTerm) {
            $gitIgnoreContents = '';
            $gitIgnorePath = base_path('.gitignore');
            if (file_exists($gitIgnorePath)) {
                $gitIgnoreContents = file_get_contents($gitIgnorePath);
            }

            // Periksa apakah file seharusnya diabaikan
            $shouldBeIgnored = false;
            if ($gitIgnoreContents !== '') {
                $ignorePatterns = preg_split("/\r\n|\n|\r/", $gitIgnoreContents);
                foreach ($ignorePatterns as $pattern) {
                    // Periksa apakah file cocok dengan pola di .gitignore
                    if (Str::is($pattern, $file)) {
                        $shouldBeIgnored = true;
                        break;
                    }
                }
            }

            // Hanya termasuk file yang tidak seharusnya diabaikan dan sesuai dengan kriteria pencarian
            return !$shouldBeIgnored && strpos($file, $searchTerm) !== false;
        }));

        // Mengonversi hasil array ke dalam instance Collection
        $filteredFiles = new Collection($filteredFiles);

        return $filteredFiles;
    }
}
