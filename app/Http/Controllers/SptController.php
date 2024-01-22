<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\extPendamping;
use App\Models\Pendamping;
use App\Models\perencanaan;
use App\Models\surat;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Carbon\Carbon as carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class SptController extends Controller
{

    public function create()
    {
        return view('pages.suratPerintahTugas.create');
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomor_spt' => 'required',
                'tanggal_spt' => 'required|date',
                'petugas_pemeriksa_nama' => 'nullable',
                'petugas_pemeriksa_npp' => 'nullable',
                'pendamping_nama.*' => 'nullable',
                'pendamping_npp.*' => 'nullable',
                'ext_pendamping_nama' => 'nullable',
                'jabatan' => 'nullable',
            ]);

            if (!$request->has('tanggal_spt')) {
                $validatedData['tanggal_spt'] = now();
            }

            $perencanaan = perencanaan::where('status', 'approved')->latest()->first();

            if (!$perencanaan) {
                return redirect()->back()->with('error', 'Perencanaan Belum Di Approve');
            }

            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();

            $tanggalPemeriksaanPertama = $badanUsaha->min('jadwal_pemeriksaan');
            $tanggalPemeriksaanTerakhir = $badanUsaha->max('jadwal_pemeriksaan');

            // Gunakan tanggal pemeriksaan badan usaha pertama dan terakhir untuk menentukan rentang
            $tanggalMulai = Carbon::parse($tanggalPemeriksaanPertama)->translatedFormat('d F Y');
            $tanggalAkhir = Carbon::parse($tanggalPemeriksaanTerakhir)->translatedFormat('d F Y');
            $tanggalPemeriksaan = $tanggalMulai . " - " . $tanggalAkhir;

            $dateNow = Carbon::now()->translatedFormat('d F Y', 'id');


            $badanUsaha->transform(function ($item) {
                $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
                return $item;
            });

            $spt = SuratPerintahTugas::where('nomor_spt', $request->input('nomor_spt'))->first();

            if (!$spt) {
                $spt = new SuratPerintahTugas([
                    'nomor_spt' => $request->input('nomor_spt'),
                    'tanggal_spt' => $request->input('tanggal_spt'),
                ]);

                $spt->save();
            }

            $petugasPemeriksa = $spt->timPemeriksa()->create([
                'nama' => $request->input('petugas_pemeriksa_nama'),
                'npp' => $request->input('petugas_pemeriksa_npp'),
            ]);

            $pendampingNama = $request->input('pendamping_nama');
            $pendampingNPP = $request->input('pendamping_npp');

            $pendamping = [];

            foreach ($pendampingNama as $key => $nama) {
                if (!empty($nama)) {
                    $pendamping[] = $spt->pendamping()->create([
                        'nama' => $nama,
                        'npp' => $pendampingNPP[$key],
                    ]);
                }
            }

            $extPendamping = $spt->extPendamping()->create([
                'nama' => $request->input('ext_pendamping_nama'),
                'jabatan' => $request->input('jabatan'),
            ]);

            $existingSurat = surat::where('nomor_surat', $request->nomor_spt)->first();

            if ($existingSurat) {
                return redirect($existingSurat->file_path)->with('success', 'Surat Pemberitahuan Hasil Pemeriksaan sudah ada!!');
            }

            $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

            $pdf = Pdf::loadView('pages.suratPerintahTugas.show', compact('spt', 'badanUsaha', 'pendamping', 'employee', 'tanggalPemeriksaan', 'dateNow'));

            $pdfFileName = 'Surat Perintah Tugas ' . str_replace('/', ' ', $spt->nomor_spt) . '  ' . Carbon::parse($spt->tanggal_spt)->isoFormat('MMMM Y') . '.pdf';

            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));


            $pdfPath = 'storage/pdf/' . $pdfFileName;
            $surat = new surat();
            $surat->perencanaan_id = $perencanaan->id;
            $surat->jenis_surat = 'Surat Perintah Tugas';
            $surat->nomor_surat = $request->input('nomor_spt');
            $surat->badan_usaha_id = $badanUsaha->first()->id;
            $surat->tanggal_surat = $request->input('tanggal_spt');
            $surat->file_path = $pdfPath;

            $surat->save();
            return redirect($pdfPath)->with('success', 'Surat Perintah Tugas Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat surat perintah tugas: ' . $e->getMessage());
        }
    }
}
