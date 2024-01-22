<?php

namespace App\Http\Controllers;

use App\Exports\lhpa as ExportsLhpa;
use App\Exports\lhps as ExportsLhps;
use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\kertasKerja;
use App\Models\lhpa;
use App\Models\lhps;
use App\Models\perencanaan;
use App\Models\sphp;
use App\Models\surat;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function indexLHPS(Request $request)
    {
        $perencanaan = perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');

        if ($periodePemeriksaan) {

            $perencanaanId = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->value('id');

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
        } else {
            $badanUsaha = BadanUsaha::all();
        }
        return view('pages.laporanPemeriksaan.lhps.index', compact('badanUsaha', 'perencanaan'));
    }
    public function createLHPS($id)
    {
        try {

            $badanUsaha = BadanUsaha::findOrFail($id);
            $spt = SuratPerintahTugas::latest()->first();

            $kertasKerja = kertasKerja::where('badan_usaha_id', $id)->latest()->first();
            if ($kertasKerja === null) {
                return redirect('/kertas-kerja')->with('error', 'Kertas Kerja Belum Diisi');
            }
            return view('pages.laporanPemeriksaan.lhps.create', compact('badanUsaha', 'spt', 'kertasKerja'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }
    }
    public function storeLHPS(Request $request)
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

            ]);

            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $lhps = new lhps();
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

            $excelFileName = 'Laporan Hasil Pemeriksaan Sementara ' . $badanUsaha->nama_badan_usaha . ' ' . Carbon::parse($lhps->tgl_lhps)->isoFormat('MMMM Y') . '.xlsx';
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {

                return redirect($existingSurat->file_path)->with('success', 'Laporan Pemeriksaan sudah ada!!');
            }
            Excel::store(new ExportsLhps($badanUsaha, $spt, $lhps), 'public/excel/' . $excelFileName);
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
            return redirect()->back()->with('error', 'Laporan Hasil Pemeriksaan Sementara Gagal Dibuat : ' . $e->getMessage());
        }
    }
    public function indexLHPA(Request $request)
    {
        $perencanaan = perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');

        if ($periodePemeriksaan) {

            $perencanaanId = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->value('id');

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
        } else {
            $badanUsaha = BadanUsaha::all();
        }
        return view('pages.laporanPemeriksaan.lhpa.index', compact('badanUsaha', 'perencanaan'));
    }
    public function createLHPA($id)
    {
        try {
            $badanUsaha = BadanUsaha::findOrFail($id);
            $spt = SuratPerintahTugas::latest()->first();
            $lhps = lhps::where('badan_usaha_id', $badanUsaha->id)->latest()->first();

            return view('pages.laporanPemeriksaan.lhpa.create', compact('badanUsaha', 'spt', 'lhps'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Badan Usaha Tidak Ditemukan');
        }
    }
    public function storeLHPA(Request $request)
    {
        try {
            $request->validate([
                'bu_id' => 'required',
                'spt_id' => 'required',
                'jumlah_tunggakan' => 'required',
                'bulan_menunggak' => 'required',
                'jumlah_pekerja' => 'nullable',
                'tmtLastYearBulan' => 'nullable',
                'tmtLastYearNominal' => 'nullable',
                'tmtLastyearPembayaran' => 'nullable',
                'thisYearBulan' => 'nullable',
                'thisYearNominal' => 'nullable',
                'thisYearPembayaran' => 'nullable',
                'tindak_lanjut' => 'required',
                'tanggal_bayar' => 'nullable',
                'rekomendasi_pemeriksa' => 'required',
            ]);

            $lhpa = new lhpa();
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $lhpa->badan_usaha_id = $request->input('bu_id');
            $spt = $request->input('spt_id');
            $jumlahTunggakan = $request->input('jumlah_tunggakan');
            $badanUsaha->jumlah_bulan_menunggak = $request->input('bulan_menunggak');
            $lhpa->jumlah_bulan_menunggak = $request->input('bulan_menunggak');
            $lhpa->jumlah_pekerja = $request->input('jumlah_pekerja');
            $lhpa->last_year_bulan = $request->input('tmtLastYearBulan');
            $lhpa->last_year_nominal = $request->input('tmtLastYearNominal');
            $lhpa->last_year_pembayaran = $request->input('tmtLastyearPembayaran');
            $lhpa->this_year_bulan = $request->input('thisYearBulan');
            $lhpa->this_year_nominal = $request->input('thisYearNominal');
            $lhpa->this_year_pembayaran = $request->input('thisYearPembayaran');
            $badanUsaha->tanggal_bayar = $request->input('tanggal_bayar');
            $lhpa->tgl_lhpa = Carbon::now()->format('Y-m-d');
            $badanUsaha->jumlah_bayar = $lhpa->last_year_pembayaran + $lhpa->this_year_pembayaran;

            $badanUsaha->hasil_pemeriksaan = $request->input('rekomendasi_pemeriksa');
            $badanUsaha->save();


            $lhpa->tindak_lanjut = $request->input('tindak_lanjut');
            $lhpa->rekomendasi_pemeriksa = $request->input('rekomendasi_pemeriksa');

            if (empty($lhpa->last_year_bulan)) {
                $lhpa->last_year_bulan = 0;
            }
            if (empty($lhpa->last_year_nominal)) {
                $lhpa->last_year_nominal = 0;
            }
            if (empty($lhpa->last_year_pembayaran)) {
                $lhpa->last_year_pembayaran = 0;
            }
            if (empty($lhpa->this_year_bulan)) {
                $lhpa->this_year_bulan = 0;
            }
            if (empty($lhpa->this_year_nominal)) {
                $lhpa->this_year_nominal = 0;
            }
            if (empty($lhpa->this_year_pembayaran)) {
                $lhpa->this_year_pembayaran = 0;
            }

            $lhpa->save();

            $excelFileName = 'Laporan Hasil Pemeriksaan Akhir ' . $badanUsaha->nama_badan_usaha . ' ' . Carbon::parse($lhpa->tgl_lhpa)->isoFormat('MMMM Y') . '.xlsx';
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {
                return redirect($existingSurat->file_path)->with('success', 'Laporan Pemeriksaan sudah ada!!');
            }
            Excel::store(new ExportsLhpa($badanUsaha, $spt, $lhpa), 'public/excel/' . $excelFileName);
            $pdfPath = 'storage/excel/' . $excelFileName;
            $surat = new surat();
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->tanggal_surat   = $lhpa->tgl_lhpa;
            $surat->jenis_surat = 'Laporan Hasil Pemeriksaan Sementara';
            $surat->nomor_surat = $excelFileName;
            $surat->file_path = $pdfPath;
            $surat->save();
            return redirect($pdfPath)->with('success', 'Laporan Hasil Pemeriksaan Akhir Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Laporan Hasil Pemeriksaan Akhir Gagal Dibuat : ' . $e->getMessage());
        }
    }
    public function indexSPHP(Request $request)
    {
        $perencanaan = perencanaan::all();

        $periodePemeriksaan = $request->input('periode_pemeriksaan');

        if ($periodePemeriksaan) {

            $perencanaanId = Perencanaan::where('tanggal_awal', $periodePemeriksaan)->value('id');

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();
        } else {
            $badanUsaha = BadanUsaha::all();
        }
        return view('pages.laporanPemeriksaan.sphp.index', compact('badanUsaha', 'perencanaan'));
    }
    public function createSPHP($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();
        return view('pages.laporanPemeriksaan.sphp.create', compact('badanUsaha', 'spt'));
    }

    public function storeSPHP(Request $request)
    {
        try {
            $request->validate([
                'badan_usaha_id' => 'required',
                'no_sphp' => 'required',
                'tgl_sphp' => 'required',
                'p-a' => 'required',
                'p-b' => 'required',
                'p-c' => 'required',
            ]);
            $existingSurat = surat::where('nomor_surat', $request->no_sphp)->first();

            if ($existingSurat) {
                return redirect($existingSurat->file_path)->with('success', 'Surat Pemberitahuan Hasil Pemeriksaan sudah ada!!');
            }

            $badanUsaha = BadanUsaha::findOrFail($request->badan_usaha_id);
            $sphp = new sphp();
            $sphp->no_sphp = $request->input('no_sphp');
            $sphp->tgl_sphp = $request->input('tgl_sphp');
            $sphp->point_a = $request->input('p-a');
            $sphp->point_b = $request->input('p-b');
            $sphp->point_c = $request->input('p-c');
            $sphp->badan_usaha_id = $request->input('badan_usaha_id');
            $spt = SuratPerintahTugas::latest()->first();

            $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

            $sphp->save();

            $pdf = Pdf::loadView('pages.laporanPemeriksaan.sphp.export', compact('sphp', 'badanUsaha', 'spt', 'employee'));

            $pdfFileName = 'Surat Pemberitahuan Hasil Pemeriksaan ' . $badanUsaha->nama_badan_usaha . '_' . str_replace('/', '_', $sphp->no_sphp) . '.pdf';
        
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));
            $pdfPath = 'storage/pdf/' . $pdfFileName;
            $surat = new surat();
            $surat->badan_usaha_id = $badanUsaha->id;
            $surat->perencanaan_id = $badanUsaha->perencanaan_id;
            $surat->tanggal_surat   = $sphp->tgl_sphp;
            $surat->jenis_surat = 'Laporan Hasil Pemeriksaan Sementara';
            $surat->nomor_surat = $sphp->no_sphp;
            $surat->file_path = $pdfPath;
            $surat->save();
            return redirect($pdfPath)->with('success', 'Surat Pemberitahuan Hasil Pemeriksaan Berhasil Dibuat');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Surat Pemberitahuan Hasil Pemeriksaan gagal dibuat : ' . $e->getMessage());
        }
    }
}
