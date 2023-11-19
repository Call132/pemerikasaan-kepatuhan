<?php

namespace App\Http\Controllers;

use App\Exports\lhps;
use App\Models\BadanUsaha;
use App\Models\dokumentasiPemeriksaan;
use App\Models\kertasKerja;
use App\Models\lhps as ModelsLhps;
use App\Models\perencanaan;
use App\Models\surat;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class lhpsController extends Controller
{
    public function index()
    {
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('lhps', compact('badanUsaha', 'perencanaan'));
    }

    public function cari(Request $request)
    {
        $request->validate([
            'periode_pemeriksaan' => 'required',
            'kategori' => 'required',
        ]);

        $start_date = $request->input('periode_pemeriksaan');
        $kategori = $request->input('kategori');

        // Ambil data Badan Usaha berdasarkan kedua kriteria pencarian
        $perencanaan = perencanaan::where('start_date', 'like', "%" . $start_date . "%")->get();


        foreach ($perencanaan as $p) {
            $p->id;
        }

        $badanUsaha = DB::table('badan_usaha')
            ->where('jenis_pemeriksaan', 'like', "%" . $kategori . "%")->where('perencanaan_id', $p->id)->get();

        if ($kategori == 'final') {
            $badanUsaha = BadanUsaha::where('jenis_pemeriksaan', 'kantor')->where('perencanaan_id', $p->id)->get();
        }
        return view('lhps', compact('badanUsaha', 'perencanaan'));
    }

    public function form($id)
    {
        try {
            $badanUsaha = BadanUsaha::findOrFail($id);
            $spt = SuratPerintahTugas::latest()->first();

            $kertasKerja = kertasKerja::where('badan_usaha_id', $id)->latest()->first();
            if ($kertasKerja === null) {
                return redirect('/kertas-kerja')->with('error', 'Kertas Kerja Belum Diisi');
            }

            return view('form-lhps', compact('badanUsaha', 'spt', 'kertasKerja'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }
    }

    public function store(Request $request)
    {

        try {
            $validate = $request->validate([
                'spt_id' => 'required',
                'jumlah_tunggakan' => 'required',
                'bulan_menunggak' => 'required',
                'jumlah_pekerja' => 'required',
                'tmtLastYearBulan' => 'nullable',
                'tmtLastYearNominal' => 'nullable',
                'thisYearBulan' => 'nullable',
                'thisYearNominal' => 'nullable',
                'tanggapan_bu' => 'required',
                'rekomendasi_pemeriksa' => 'required',
                //'image*' => 'image|file|max:2048',
            ]);

            /*if ($request->file('image')) {
                $imagePath = $request->file('image')->store('public/image');
                $validate['image'] = 'public/image' . base64_encode(Storage::get($imagePath));
            }*/
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $lhps = new ModelsLhps();
            $lhps->tgl_lhps = Carbon::now()->format('Y-m-d');
            $lhps->badan_usaha_id = $badanUsaha->id;
            $spt = $request->input('spt_id');
            $jumlahTunggakan = $request->input('jumlah_tunggakan');
            $lhps->jumlah_bulan_menunggak = $request->input('bulan_menunggak');
            $lhps->jumlah_pekerja = $request->input('jumlah_pekerja');
            $lhps->last_year_bulan = $request->input('tmtLastYearBulan');
            $lhps->last_year_nominal = $request->input('tmtLastYearNominal');
            $lhps->this_year_bulan = $request->input('thisYearBulan');
            $lhps->this_year_nominal = $request->input('thisYearNominal');
            $lhps->tanggapan_bu = $request->input('tanggapan_bu');
            $lhps->rekomendasi_pemeriksa = $request->input('rekomendasi_pemeriksa');
            //$lhps->image = $validate['image'];


            if (empty($lhps->last_year_bulan)) {
                $lhps->last_year_bulan = 0;
            }
            if (empty($lhps->last_year_nominal)) {
                $lhps->last_year_nominal = 0;
            }
            if (empty($lhps->this_year_bulan)) {
                $lhps->this_year_bulan = 0;
            }
            if (empty($lhps->this_year_nominal)) {
                $lhps->this_year_nominal = 0;
            }

            $lhps->save();

            $excelFileName = 'Laporan Hasil Pemeriksaan Sementara' . $badanUsaha->nama_badan_usaha . ' ' . Carbon::parse($lhps->tgl_lhps)->isoFormat('MMMM Y') . '.xlsx';
            Excel::store(new lhps($badanUsaha, $spt, $lhps), 'public/excel/' . $excelFileName);
            $excelPath = 'storage/excel/' . $excelFileName;

            $surat = new surat();
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->tanggal_surat   = $lhps->tgl_lhps;
            $surat->jenis_surat = 'Laporan Hasil Pemeriksaan Sementara';
            $surat->nomor_surat = $excelFileName;
            $surat->file_path = $excelPath;
            $surat->save();
            return redirect($excelPath)->with('success', 'Laporan Hasil Pemeriksaan Sementara Berhasil Dibuat');
        } catch (\Exception $e) {
            return dd($e);
            return redirect()->back()->with('error', 'Laporan Hasil Pemeriksaan Sementara Gagal Dibuat');
        }
    }
    public function dokumentasi($id)
    {

        try {
            $badanUsaha = BadanUsaha::findOrFail($id);
            $lhps = ModelsLhps::findOrFail($id, 'badan_usaha_id')->latest()->first();
            $spt = SuratPerintahTugas::latest()->first();
            $timPemeriksa = $spt->timPemeriksa;
            $pendamping = $spt->pendamping;
            $extPendamping = $spt->extPendamping;
            if (empty($lhps)) {
                return redirect()->back()->with('error', 'Laporan Hasil Pemeriksaan Sementara Belum Dibuat');
            }

            $pdf = Pdf::loadView('dokumentasi-preview', compact('badanUsaha', 'spt', 'lhps', 'timPemeriksa', 'pendamping', 'extPendamping'));
            $pdf->setPaper('A4', 'landscape');
            $pdfFileName = 'Dokumentasi Laporan Hasil Pemeriksaan Sementara ' . $badanUsaha->nama_badan_usaha . '-' . $lhps->tgl_lhps . '.pdf';
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));

            $pdfPath = 'storage/pdf/' . $pdfFileName;

            return redirect($pdfPath)->with('success', 'Dokumentasi Laporan Hasil Pemeriksaan Sementara Berhasil Dibuat');
        } catch (\Exception $e) {
            return dd($e);
        }
    }
}
