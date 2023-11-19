<?php

namespace App\Http\Controllers;

use App\Exports\lhpa;
use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\kertasKerja;
use App\Models\lhpa as ModelsLhpa;
use App\Models\lhps;
use App\Models\perencanaan;
use App\Models\sphp;
use App\Models\surat;
use App\Models\SuratPerintahTugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;

class laporanPemeriksaanController extends Controller
{
    public function sphp()
    {
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('sphp', compact('badanUsaha', 'perencanaan'));
    }
    public function cariSphp(Request $request)
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
        return view('sphp', compact('badanUsaha', 'perencanaan'));
    }
    public function formSphp($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $spt = SuratPerintahTugas::latest()->first();
        return view('form-sphp', compact('badanUsaha', 'spt'));
    }
    public function storeSphp(Request $request)
    {
        try {
            $request->validate([
                'badan_usaha_id' => 'required',
                'no_sphp' => 'required|unique:sphp',
                'tgl_sphp' => 'required',
                'p-a' => 'required',
                'p-b' => 'required',
                'p-c' => 'required',
            ]);

            $badanUsaha = BadanUsaha::findOrFail($request->badan_usaha_id);
            $sphp = new sphp();
            $sphp->no_sphp = $request->input('no_sphp');
            $sphp->tgl_sphp = $request->input('tgl_sphp');
            $sphp->p_a = $request->input('p-a');
            $sphp->p_b = $request->input('p-b');
            $sphp->p_c = $request->input('p-c');
            $sphp->badan_usaha_id = $request->input('badan_usaha_id');
            $spt = SuratPerintahTugas::latest()->first();

            $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

            $sphp->save();

            $pdf = Pdf::loadView('sphp-preview', compact('sphp', 'badanUsaha', 'spt', 'employee'));

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
            return redirect()->back()->with('error', 'Nomor Surat Pemberitahuan Hasil Pemeriksaan sudah ada');
        }
    }

    public function lhpa()
    {
        $badanUsaha = BadanUsaha::all();
        $perencanaan = perencanaan::all();
        return view('lhpa', compact('badanUsaha', 'perencanaan'));
    }

    public function cariLhpa(Request $request)
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
        return view('lhpa', compact('badanUsaha', 'perencanaan'));
    }

    public function formLhpa($id)
    {
        try {
            $badanUsaha = BadanUsaha::findOrFail($id);
            $spt = SuratPerintahTugas::latest()->first();
            $lhps = lhps::where('badan_usaha_id', $badanUsaha->id)->latest()->first();

            return view('form-lhpa', compact('badanUsaha', 'spt', 'lhps'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Badan Usaha Tidak Ditemukan');
        }
    }

    public function storeLhpa(Request $request)
    {
        try {
            $request->validate([
                'bu_id' => 'required',
                'spt_id' => 'required',
                'jumlah_tunggakan' => 'required',
                'bulan_menunggak' => 'required',
                'jumlah_pekerja' => 'required',
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

            $lhpa = new ModelsLhpa();
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $lhpa->badan_usaha_id = $request->input('bu_id');
            $spt = $request->input('spt_id');
            $jumlahTunggakan = $request->input('jumlah_tunggakan');
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
            Excel::store(new lhpa($badanUsaha, $spt, $lhpa), 'public/excel/' . $excelFileName);
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
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
    }
}
