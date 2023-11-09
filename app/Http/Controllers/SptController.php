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
use PhpParser\Node\Stmt\TryCatch;

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

        $badanUsahaDiajukan = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();
        $tanggalMulai = Carbon::parse($perencanaan->start_date)->translatedFormat('d F Y');
        $tanggalAkhir = Carbon::parse($perencanaan->end_date)->translatedFormat('d F Y');
        $tanggalPemeriksaan = $tanggalMulai . " - " . $tanggalAkhir;
        $dateNow = Carbon::now()->translatedFormat('d F Y', 'id');

        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });

        // Cari SPT dengan nomor yang sama
        $spt = SuratPerintahTugas::where('nomor_spt', $request->input('nomor_spt'))->first();

        // Jika SPT tidak ada, buat yang baru
        if (!$spt) {
            $spt = new SuratPerintahTugas([
                'nomor_spt' => $request->input('nomor_spt'),
                'tanggal_spt' => $request->input('tanggal_spt'),
            ]);

            $spt->save();
        }

        // Simpan tim pemeriksa
        $petugasPemeriksa = $spt->timPemeriksa()->create([
            'nama' => $request->input('petugas_pemeriksa_nama'),
            'npp' => $request->input('petugas_pemeriksa_npp'),
        ]);


        // $spt->timPemeriksa()->save($petugasPemeriksa);

        // Simpan anggota pendamping
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

        

        // $spt->pendamping()->createMany($pendamping);

        // Simpan anggota eksternal pendamping
        $extPendamping = $spt->extPendamping()->create([
            'nama' => $request->input('ext_pendamping_nama'),
            'jabatan' => $request->input('jabatan'),
        ]);
        // $spt->extPendamping()->save($extPendamping);

        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();

        $pdf = Pdf::loadView('spt-preview', compact('spt', 'badanUsahaDiajukan','pendamping' ,'employee', 'tanggalPemeriksaan', 'dateNow'));

        $pdfFileName = 'Surat Perintah Tugas ' . $spt->nomor_spt . '.pdf';


        Log::info('Surat Perintah Tugas ' . $spt->nomor_spt . ' telah dicetak');


        return $pdf->download($pdfFileName);
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
        return view('spt-preview'); // Sesuaikan dengan nama tampilan Anda
    }
}
