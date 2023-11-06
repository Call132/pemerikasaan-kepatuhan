<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\Pendamping;
use App\Models\perencanaan;
use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon as carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;

class SptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Middleware otentikasi
    }
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




    // Menyimpan SPT yang baru dibuat
    public function store(Request $request)

    {

        // Validasi input dari form
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
            $validatedData['tanggal_spt'] = now(); // Atur tanggal default jika tidak ada input 'tanggal_spt'
        }

        // Simpan data SPT ke dalam database
        $spt = new SuratPerintahTugas($validatedData);
        $spt->save();
        //dd($spt);




        // Simpan data petugas pemeriksa dan pendamping
        $spt->timPemeriksa()->create([
            'nama' => $request->input('petugas_pemeriksa_nama'),
            'npp' => $request->input('petugas_pemeriksa_npp'),
        ]);

        $pendampingNama = $request->input('pendamping_nama');
        $pendampingNPP = $request->input('pendamping_npp');

        foreach ($pendampingNama as $key => $nama) {
            if (!empty($nama)) {
                $pendamping = new Pendamping([
                    'nama' => $nama,
                    'npp' => $pendampingNPP[$key],
                ]);
                $spt->pendamping()->save($pendamping);
            }
        }

        $spt->extPendamping()->create([
            'nama' => $request->input('ext_pendamping_nama'),
            'jabatan' => $request->input('jabatan'),
        ]);


        $employee = employee_roles::where('posisi', 'Kepala Cabang')->pluck('nama')->first();




        // Mengambil data perencanaan
        $perencanaan = perencanaan::where('status', 'approved')->latest()
            ->first();
        $badanUsahaDiajukan = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();
        
        if ($perencanaan) {
            // Mengonversi tanggal ke format Indonesia
            $tanggalMulai = Carbon::parse($perencanaan->start_date)->translatedFormat('d F Y');
            $tanggalAkhir = carbon::parse($perencanaan->end_date)->translatedFormat('d F Y');
        } else {
            // Handle the case where no 'approved' records were found
            return response()->json(['error' => 'No approved records found'], 404);
            // You might want to show an error message or take appropriate action.
        }



        // Mengganti teks dengan tanggal awal dan tanggal akhir
        $tanggalPemeriksaan = $tanggalMulai . " - " . $tanggalAkhir;

        $dateNow = Carbon::now()->translatedFormat('d F Y', 'id');

        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });


        
        //return view('spt-preview', compact('badanUsahaDiajukan'))->with('success', 'SPT berhasil disimpan.');
        // Generate the PDF

        $pdf = FacadePdf::loadView('spt-preview', compact('spt', 'badanUsahaDiajukan', 'employee', 'tanggalPemeriksaan', 'dateNow'));



        // Generate a unique filename for the PDF (you can customize this)
        $pdfFileName = 'Surat Perintah Tugas ' . $spt->nomor_spt . '.pdf';

        // Optionally, you can save the PDF to a directory on your server
        $pdfFilePath = storage_path('/public/docs' . $pdfFileName);



        // Download the PDF
        return $pdf->download($pdfFileName);

        // Pass the $spt variable to the view
        return view('spt-preview', compact('spt', 'badanUsahaDiajukan'))->with('success', 'SPT berhasil disimpan.');

        //return redirect()->route('pengiriman-surat')->with('success', 'SPT berhasil disimpan.');
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
