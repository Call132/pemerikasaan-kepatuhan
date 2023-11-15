<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\extPendamping;
use App\Models\Pendamping;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use App\Models\TimPemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Carbon\Carbon as carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class SptController extends Controller
{

    public function create()
    {
        $badanUsahaDiajukan = DB::table('perencanaan')
            ->join('badan_usaha', 'perencanaan.id', '=', 'badan_usaha.perencanaan_id')
            ->where('perencanaan.status', 'approved')
            ->select('badan_usaha.*')
            ->get();

        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });

        return view('spt-preview', compact('badanUsahaDiajukan'));
    }




    public function storeSpt(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomor_spt' => 'required|unique:surat_perintah_tugas',
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
        
        $badanUsahaDiajukan = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();

// Ambil tanggal pemeriksaan badan usaha pertama dan terakhir
$tanggalPemeriksaanPertama = $badanUsahaDiajukan->min('jadwal_pemeriksaan');
$tanggalPemeriksaanTerakhir = $badanUsahaDiajukan->max('jadwal_pemeriksaan');

// Gunakan tanggal pemeriksaan badan usaha pertama dan terakhir untuk menentukan rentang
$tanggalMulai = Carbon::parse($tanggalPemeriksaanPertama)->translatedFormat('d F Y');
$tanggalAkhir = Carbon::parse($tanggalPemeriksaanTerakhir)->translatedFormat('d F Y');
$tanggalPemeriksaan = $tanggalMulai . " - " . $tanggalAkhir;

$dateNow = Carbon::now()->translatedFormat('d F Y', 'id');


            $badanUsahaDiajukan->transform(function ($item) {
                $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
                return $item;
            });

            // Cari SPT dengan nomor yang sama
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
            $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

            $pdf = Pdf::loadView('spt-preview', compact('spt', 'badanUsahaDiajukan', 'pendamping', 'employee', 'tanggalPemeriksaan', 'dateNow'));

            $pdfFileName = 'Surat Perintah Tugas ' . str_replace('/', '-', $spt->nomor_spt) . '_' . $spt->created_at->format('Ymd_His') . '.pdf';

            // Simpan file PDF ke direktori storage/app/public/spt
            $pdf->save(storage_path('app/public/pdf/' . $pdfFileName));

            $pdfPath = 'storage/pdf/' . $pdfFileName;
            return redirect($pdfPath)->with('success', 'Surat Perintah Tugas Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat surat perintah tugas: ' . $e->getMessage());
        }
    }


    // Menampilkan daftar BU
    public function index()
    {
        $badanUsahaDiajukan = DB::table('perencanaan')
            ->join('badan_usaha', 'perencanaan.id', '=', 'badan_usaha.perencanaan_id')
            ->where('perencanaan.status', 'approved')
            ->select('badan_usaha.*')
            ->get();



        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });


        $sptList = SuratPerintahTugas::all();
        return view('spt-preview', compact('badanUsahaDiajukan'));
    }
    public function preview()
    {
        return view('spt-preview');
    }
}
